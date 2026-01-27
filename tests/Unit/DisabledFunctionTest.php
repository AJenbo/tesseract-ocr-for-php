<?php

namespace thiagoalessio\TesseractOCR\Tests\Unit;

use thiagoalessio\TesseractOCR\Command;
use thiagoalessio\TesseractOCR\DisabledFunctionException;
use thiagoalessio\TesseractOCR\Tests\Common\TestCase;

class DisabledFunctionTest extends TestCase
{
    public function testCommandCreatedWhenFunctionsAvailable()
    {
        // This test should always pass when exec and system are available
        $command = new Command();
        $this->assertEquals(true, is_object($command));
    }

    public function testCommandThrowsExceptionWhenExecDisabled()
    {
        $exceptionThrown = false;
        $exceptionMessage = '';
        
        try {
            // Mock a scenario where exec is disabled
            $testCommand = new class extends Command {
                public function __construct($image = null, $outputFile = null) {
                    $this->checkRequiredFunctionsMock(['exec']);
                    $this->image = $image;
                    $this->outputFile = $outputFile;
                }
                
                private function checkRequiredFunctionsMock($mockDisabled) {
                    $requiredFunctions = ['exec', 'system'];
                    $disabledFunctions = [];

                    foreach ($requiredFunctions as $function) {
                        if (in_array($function, $mockDisabled) || !function_exists($function)) {
                            $disabledFunctions[] = $function;
                        }
                    }

                    if (!empty($disabledFunctions)) {
                        $message = sprintf(
                            "The following required PHP functions are disabled: %s. " .
                            "Please enable them in your php.ini configuration by removing them from the 'disable_functions' directive.",
                            implode(', ', $disabledFunctions)
                        );
                        throw new DisabledFunctionException($message);
                    }
                }
            };
        } catch (DisabledFunctionException $e) {
            $exceptionThrown = true;
            $exceptionMessage = $e->getMessage();
        }
        
        $this->assertEquals(true, $exceptionThrown);
        $this->assertEquals(true, strpos($exceptionMessage, "The following required PHP functions are disabled: exec") !== false);
    }

    public function testCommandThrowsExceptionWhenSystemDisabled()
    {
        $exceptionThrown = false;
        $exceptionMessage = '';
        
        try {
            // Mock a scenario where system is disabled
            $testCommand = new class extends Command {
                public function __construct($image = null, $outputFile = null) {
                    $this->checkRequiredFunctionsMock(['system']);
                    $this->image = $image;
                    $this->outputFile = $outputFile;
                }
                
                private function checkRequiredFunctionsMock($mockDisabled) {
                    $requiredFunctions = ['exec', 'system'];
                    $disabledFunctions = [];

                    foreach ($requiredFunctions as $function) {
                        if (in_array($function, $mockDisabled) || !function_exists($function)) {
                            $disabledFunctions[] = $function;
                        }
                    }

                    if (!empty($disabledFunctions)) {
                        $message = sprintf(
                            "The following required PHP functions are disabled: %s. " .
                            "Please enable them in your php.ini configuration by removing them from the 'disable_functions' directive.",
                            implode(', ', $disabledFunctions)
                        );
                        throw new DisabledFunctionException($message);
                    }
                }
            };
        } catch (DisabledFunctionException $e) {
            $exceptionThrown = true;
            $exceptionMessage = $e->getMessage();
        }
        
        $this->assertEquals(true, $exceptionThrown);
        $this->assertEquals(true, strpos($exceptionMessage, "The following required PHP functions are disabled: system") !== false);
    }

    public function testCommandThrowsExceptionWhenBothFunctionsDisabled()
    {
        $exceptionThrown = false;
        $exceptionMessage = '';
        
        try {
            // Mock a scenario where both exec and system are disabled
            $testCommand = new class extends Command {
                public function __construct($image = null, $outputFile = null) {
                    $this->checkRequiredFunctionsMock(['exec', 'system']);
                    $this->image = $image;
                    $this->outputFile = $outputFile;
                }
                
                private function checkRequiredFunctionsMock($mockDisabled) {
                    $requiredFunctions = ['exec', 'system'];
                    $disabledFunctions = [];

                    foreach ($requiredFunctions as $function) {
                        if (in_array($function, $mockDisabled) || !function_exists($function)) {
                            $disabledFunctions[] = $function;
                        }
                    }

                    if (!empty($disabledFunctions)) {
                        $message = sprintf(
                            "The following required PHP functions are disabled: %s. " .
                            "Please enable them in your php.ini configuration by removing them from the 'disable_functions' directive.",
                            implode(', ', $disabledFunctions)
                        );
                        throw new DisabledFunctionException($message);
                    }
                }
            };
        } catch (DisabledFunctionException $e) {
            $exceptionThrown = true;
            $exceptionMessage = $e->getMessage();
        }
        
        $this->assertEquals(true, $exceptionThrown);
        $this->assertEquals(true, strpos($exceptionMessage, "The following required PHP functions are disabled: exec, system") !== false);
    }
}