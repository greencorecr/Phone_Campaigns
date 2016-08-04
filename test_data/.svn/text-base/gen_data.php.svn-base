#!/usr/bin/php
<?php

    $lines = rand(20, 50);

    for($line=0; $line <= $lines; $line++)
    {
        echo '"' . create_phone_number() . '", "' . gen_amount() . '"' . "\n";
    }


    function create_phone_number()
    {
        $num = "";
        for($i=1; $i<=8; $i++)
        {
            $num .= rand(0,9);
        }
        return $num;
    }


    function gen_amount()
    {
        $amount = "";
		$len = rand(2, 9);
        for($i=1; $i<=$len; $i++)
        {
            if($i == 1)
                $digit = rand(1,9);
            else
                $digit = rand(0, 9);
                
            $amount .= $digit;
        }
        return $amount;
    }

?>
