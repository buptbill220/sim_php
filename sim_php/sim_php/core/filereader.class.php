<?php
class FileReader extends Base {
    protected $log;
    protected $filename;
    protected $starttime;
    protected $endtime;
    protected $linenum;
    protected $mode = 1;
    //donot use function to return, to get it directly is faster
    public $contents = null;
    
    const block = 4096;
    
    public function setFile($file) {
        if (!isset($file) || empty($file)) {
            throw new Errorexp("file name is unset of empty!", $this);
        }
        $this->filename = $file;
    }
    /*
    read handle function
    $mode:    1 => readByBlock
        2 => readByLine
        3 => readToContents
        4 => readToArray
        5 => readToArray (very slow)
    result:    result stored in contents variable (each element of array is one line)
    suggestion: efficiency: 4 > 1 > 3 > 2 > 5; time consume ratio: 62:107:119:159:3800
    */
    public function readFile($file, $mode = 1) {
        $this->setFile($file);
        $this->linenum = 0;
        $this->starttime = getTime(3);
        $func = $this->getReadFunc($mode);
        unset($this->contents);
        $this->$func();
        $this->endTime = getTime(3);
    }
        //read all charater in file
    public function readByLine() {
        $fp = fopen($this->filename, 'rb');
        if (!$fp) {
            throw new Errorexp('open file <' . $file . '> failed!', $this);
        }
        $linenum = 0;
        while (!feof($fp)) {
            $line = fgets($fp, 2048);
            $contents[] = $line;
            ++$linenum;
        }
        fclose($fp);
        $this->contents = &$contents;
        $this->linenum = $linenum;
    }
    //'\n' charater will be token
    private function readByBlock() {
        $fp = fopen($this->filename, 'rb');
        if (!$fp) {
            throw new Errorexp('open file <' . $file . '> failed!', $this);
        }
        
        $rem = '';
        $linenum = 0;
        while (!feof($fp)) {
            ++$linenum;
            $buf = fread($fp, self::block);
            $lines = explode("\n", $buf);
            $lines[0] = $rem . $lines[0];
            $rem = array_pop($lines);
            foreach ($lines as &$line) {
                $contents[] = &$line;
            }
        }
        $contents[] = $rem;
        fclose($fp);
        $this->contents = &$contents;
        $this->linenum = $linenum;
    }
    //'\n' charater will be token
    private function readByByte() {
        $fp = fopen($this->filename, 'rb');
        if (!$fp) {
            throw new Errorexp('open file <' . $file . '> failed!', $this);
        }
        
        $line = '';
        $char = '';
        $linenum = 0;
        while (!feof($fp)) {
            $char = fgetc($fp);
            $line .= $char;
            if ($char === "\n") {
                $contents[] = $line;
                $line = '';
                ++$linenum;
            }
        }
        $contents[] = $line;
        fclose($fp);
        $this->contents = &$contents;
        $this->linenum = $linenum;
    }
    //'\n' charater will be token
    private function readToContents() {
        $contents = file_get_contents($this->filename);
        if (!$contents) {
            throw new Errorexp('get file: <' .$this->filename . '> contents error', $this);
        }
        $linenum = 0;
        $line = strtok($contents, "\n");
        while ($line) {
            ++$linenum;
            $this->contents[] = $line;
            $line = strtok("\n");
        }
        $this->contents = &$contents;
        $this->linenum = $linenum;
    }
    //read all charater in file
    private function readToArray() {
        $this->contents = file($this->filename);
        $this->linenum = count($this->contents);
    }
        
    private function getReadFunc($mode = 1) {
        switch ($mode) {
            case 1:
                $func = 'readByBlock';
                $this->mode = 1;
                break;
            case 2:
                $func = 'readByLine';
                $this->mode = 2;
                break;
            case 3:
                $func = 'readToContents';
                $this->mode = 3;
                break;
            case 4:
                $func = 'readToArray';
                $this->mode = 4;
                break;
            case 5:
            default:
                $func = 'readByByte';
                $this->mode = 5;
        }
        return $func;
    }
}
