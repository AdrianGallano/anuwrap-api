<?php

namespace Src\Controllers;

class DocumentationController
{
    public function getDocs()
    {
        #return html content
        echo file_get_contents(__DIR__ . "\..\..\docs.html");
    }
}
