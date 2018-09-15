<?php

if( !defined( 'ABSPATH') ) exit();

class EssGridMemoryUsageInformation
{

    private $real_usage;
    private $statistics = array();

    // Memory Usage Information constructor
    public function __construct($real_usage = false)
    {
        $this->real_usage = $real_usage;
    }

    // Returns current memory usage with or without styling
    public function getCurrentMemoryUsage($with_style = true)
    {
        $mem = memory_get_usage($this->real_usage);
        return ($with_style) ? $this->byteFormat($mem) : $mem;
    }

    // Returns peak of memory usage
    public function getPeakMemoryUsage($with_style = true)
    {
        $mem = memory_get_peak_usage($this->real_usage);
        return ($with_style) ? $this->byteFormat($mem) : $mem;
    }

    // Set memory usage with info
    public function setMemoryUsage($info = '')
    {
        $this->statistics[] = array('time' => time(),
            'info' => $info,
            'memory_usage' => $this->getCurrentMemoryUsage());
    }

    // Print all memory usage info and memory limit and 
    public function printMemoryUsageInformation()
    {
		echo '<pre>';
        foreach ($this->statistics as $satistic)
        {
            echo "Time: " . $satistic['time'] .
            " | Memory Usage: " . $satistic['memory_usage'] .
            " | Info: " . $satistic['info'];
            echo "\n";
        }
        echo "\n\n";
        echo "Peak of memory usage: " . $this->getPeakMemoryUsage();
        echo "\n\n";
		echo '</pre>';
    }

    // Set start with default info or some custom info
    public function setStart($info = 'Initial Memory Usage')
    {
        $this->setMemoryUsage($info);
    }

    // Set end with default info or some custom info
    public function setEnd($info = 'Memory Usage at the End')
    {
        $this->setMemoryUsage($info);
    }

    // Byte formatting
    private function byteFormat($bytes, $unit = "", $decimals = 2)
    {
        $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4,
            'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);

        $value = 0;
        if ($bytes > 0)
        {
            // Generate automatic prefix by bytes 
            // If wrong prefix given
            if (!array_key_exists($unit, $units))
            {
                $pow = floor(log($bytes) / log(1024));
                $unit = array_search($pow, $units);
            }

            // Calculate byte value by prefix
            $value = ($bytes / pow(1024, floor($units[$unit])));
        }

        // If decimals is not numeric or decimals is less than 0 
        // then set default value
        if (!is_numeric($decimals) || $decimals < 0)
        {
            $decimals = 2;
        }

        // Format output
        return sprintf('%.' . $decimals . 'f ' . $unit, $value);
    }

}

?>