<?php

namespace Quafzi;

class Service
{
    public function getData()
    {
        $output = <<<XML
<weather>
    <clouds>%s</clouds>
    <rain>%s</rain>
    <temperature>%s</temperature>
</weather>
XML;
        return sprintf(
            $output,
            rand(0, 100),
            rand(0, 1),
            rand(-20, 40)
        );
    }
}
