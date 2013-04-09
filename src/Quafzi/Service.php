<?php

namespace Quafzi;

class Service
{
    public function getData()
    {
        if (0 == rand(0, 10)) {
            return '<invalid>response';
        }
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
