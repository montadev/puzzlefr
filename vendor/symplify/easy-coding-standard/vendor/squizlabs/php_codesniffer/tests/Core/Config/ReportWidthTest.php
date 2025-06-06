<?php

/**
 * Tests for the \PHP_CodeSniffer\Config reportWidth value.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Config;
use ECSPrefix202503\PHPUnit\Framework\TestCase;
use ReflectionProperty;
/**
 * Tests for the \PHP_CodeSniffer\Config reportWidth value.
 *
 * @covers \PHP_CodeSniffer\Config::__get
 */
final class ReportWidthTest extends TestCase
{
    /**
     * Set static properties in the Config class to prevent tests influencing each other.
     *
     * @before
     *
     * @return void
     */
    protected function cleanConfig()
    {
        // Set to the property's default value to clear out potentially set values from other tests.
        self::setStaticProperty('executablePaths', []);
        // Set to a usable value to circumvent Config trying to find a phpcs.xml config file.
        self::setStaticProperty('overriddenDefaults', ['standards' => ['PSR1']]);
        // Set to values which prevent the test-runner user's `CodeSniffer.conf` file
        // from being read and influencing the tests.
        self::setStaticProperty('configData', []);
        self::setStaticProperty('configDataFile', '');
    }
    //end cleanConfig()
    /**
     * Clean up after each finished test.
     *
     * @after
     *
     * @return void
     */
    protected function resetConfig()
    {
        $_SERVER['argv'] = [];
    }
    //end resetConfig()
    /**
     * Reset the static properties in the Config class to their true defaults to prevent this class
     * from influencing other tests.
     *
     * @afterClass
     *
     * @return void
     */
    public static function resetConfigToDefaults()
    {
        self::setStaticProperty('overriddenDefaults', []);
        self::setStaticProperty('executablePaths', []);
        self::setStaticProperty('configData', null);
        self::setStaticProperty('configDataFile', null);
        $_SERVER['argv'] = [];
    }
    //end resetConfigToDefaults()
    /**
     * Test that report width without overrules will always be set to a non-0 positive integer.
     *
     * @covers \PHP_CodeSniffer\Config::__set
     * @covers \PHP_CodeSniffer\Config::restoreDefaults
     *
     * @return void
     */
    public function testReportWidthDefault()
    {
        $config = new Config();
        // Can't test the exact value as "auto" will resolve differently depending on the machine running the tests.
        $this->assertTrue(\is_int($config->reportWidth), 'Report width is not an integer');
        $this->assertGreaterThan(0, $config->reportWidth, 'Report width is not greater than 0');
    }
    //end testReportWidthDefault()
    /**
     * Test that the report width will be set to a non-0 positive integer when not found in the CodeSniffer.conf file.
     *
     * @covers \PHP_CodeSniffer\Config::__set
     * @covers \PHP_CodeSniffer\Config::restoreDefaults
     *
     * @return void
     */
    public function testReportWidthWillBeSetFromAutoWhenNotFoundInConfFile()
    {
        $phpCodeSnifferConfig = ['default_standard' => 'PSR2', 'show_warnings' => '0'];
        $this->setStaticProperty('configData', $phpCodeSnifferConfig);
        $config = new Config();
        // Can't test the exact value as "auto" will resolve differently depending on the machine running the tests.
        $this->assertTrue(\is_int($config->reportWidth), 'Report width is not an integer');
        $this->assertGreaterThan(0, $config->reportWidth, 'Report width is not greater than 0');
    }
    //end testReportWidthWillBeSetFromAutoWhenNotFoundInConfFile()
    /**
     * Test that the report width will be set correctly when found in the CodeSniffer.conf file.
     *
     * @covers \PHP_CodeSniffer\Config::__set
     * @covers \PHP_CodeSniffer\Config::getConfigData
     * @covers \PHP_CodeSniffer\Config::restoreDefaults
     *
     * @return void
     */
    public function testReportWidthCanBeSetFromConfFile()
    {
        $phpCodeSnifferConfig = ['default_standard' => 'PSR2', 'report_width' => '120'];
        $this->setStaticProperty('configData', $phpCodeSnifferConfig);
        $config = new Config();
        $this->assertSame(120, $config->reportWidth);
    }
    //end testReportWidthCanBeSetFromConfFile()
    /**
     * Test that the report width will be set correctly when passed as a CLI argument.
     *
     * @covers \PHP_CodeSniffer\Config::__set
     * @covers \PHP_CodeSniffer\Config::processLongArgument
     *
     * @return void
     */
    public function testReportWidthCanBeSetFromCLI()
    {
        $_SERVER['argv'] = ['phpcs', '--report-width=100'];
        $config = new Config();
        $this->assertSame(100, $config->reportWidth);
    }
    //end testReportWidthCanBeSetFromCLI()
    /**
     * Test that the report width will be set correctly when multiple report widths are passed on the CLI.
     *
     * @covers \PHP_CodeSniffer\Config::__set
     * @covers \PHP_CodeSniffer\Config::processLongArgument
     *
     * @return void
     */
    public function testReportWidthWhenSetFromCLIFirstValuePrevails()
    {
        $_SERVER['argv'] = ['phpcs', '--report-width=100', '--report-width=200'];
        $config = new Config();
        $this->assertSame(100, $config->reportWidth);
    }
    //end testReportWidthWhenSetFromCLIFirstValuePrevails()
    /**
     * Test that a report width passed as a CLI argument will overrule a report width set in a CodeSniffer.conf file.
     *
     * @covers \PHP_CodeSniffer\Config::__set
     * @covers \PHP_CodeSniffer\Config::processLongArgument
     * @covers \PHP_CodeSniffer\Config::getConfigData
     *
     * @return void
     */
    public function testReportWidthSetFromCLIOverrulesConfFile()
    {
        $phpCodeSnifferConfig = ['default_standard' => 'PSR2', 'report_format' => 'summary', 'show_warnings' => '0', 'show_progress' => '1', 'report_width' => '120'];
        $this->setStaticProperty('configData', $phpCodeSnifferConfig);
        $cliArgs = ['phpcs', '--report-width=180'];
        $config = new Config($cliArgs);
        $this->assertSame(180, $config->reportWidth);
    }
    //end testReportWidthSetFromCLIOverrulesConfFile()
    /**
     * Test that the report width will be set to a non-0 positive integer when set to "auto".
     *
     * @covers \PHP_CodeSniffer\Config::__set
     *
     * @return void
     */
    public function testReportWidthInputHandlingForAuto()
    {
        $config = new Config();
        $config->reportWidth = 'auto';
        // Can't test the exact value as "auto" will resolve differently depending on the machine running the tests.
        $this->assertTrue(\is_int($config->reportWidth), 'Report width is not an integer');
        $this->assertGreaterThan(0, $config->reportWidth, 'Report width is not greater than 0');
    }
    //end testReportWidthInputHandlingForAuto()
    /**
     * Test that the report width will be set correctly for various types of input.
     *
     * @param mixed $value    Input value received.
     * @param int   $expected Expected report width.
     *
     * @dataProvider dataReportWidthInputHandling
     * @covers       \PHP_CodeSniffer\Config::__set
     *
     * @return void
     */
    public function testReportWidthInputHandling($value, $expected)
    {
        $config = new Config();
        $config->reportWidth = $value;
        $this->assertSame($expected, $config->reportWidth);
    }
    //end testReportWidthInputHandling()
    /**
     * Data provider.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataReportWidthInputHandling()
    {
        return ['No value (empty string)' => ['value' => '', 'expected' => Config::DEFAULT_REPORT_WIDTH], 'Value: invalid input type null' => ['value' => null, 'expected' => Config::DEFAULT_REPORT_WIDTH], 'Value: invalid input type false' => ['value' => \false, 'expected' => Config::DEFAULT_REPORT_WIDTH], 'Value: invalid input type float' => ['value' => 100.5, 'expected' => Config::DEFAULT_REPORT_WIDTH], 'Value: invalid string value "invalid"' => ['value' => 'invalid', 'expected' => Config::DEFAULT_REPORT_WIDTH], 'Value: invalid string value, non-integer string "50.25"' => ['value' => '50.25', 'expected' => Config::DEFAULT_REPORT_WIDTH], 'Value: valid numeric string value' => ['value' => '250', 'expected' => 250], 'Value: valid int value' => ['value' => 220, 'expected' => 220], 'Value: negative int value becomes positive int' => ['value' => -180, 'expected' => 180]];
    }
    //end dataReportWidthInputHandling()
    /**
     * Helper function to set a static property on the Config class.
     *
     * @param string $name  The name of the property to set.
     * @param mixed  $value The value to set the property to.
     *
     * @return void
     */
    public static function setStaticProperty($name, $value)
    {
        $property = new ReflectionProperty('PHP_CodeSniffer\\Config', $name);
        $property->setAccessible(\true);
        $property->setValue(null, $value);
        $property->setAccessible(\false);
    }
    //end setStaticProperty()
}
//end class
