<?php
class ConfReader extends FileReader {
    function parse($file) {
        $this->filename = $file;
        $fp = fopen($this->filename, 'rb');
        if (!$fp) {
            throw new Errorexp('open file <' . $file . '> failed!', $this);
        }
        $rem = '';
        $linenum = 0;
        while (!feof($fp)) {
            $buf = fread($fp, self::block);
            $lines = explode("\n", $buf);
            $lines[0] = $rem . $lines[0];
            $rem = array_pop($lines);
            unset($buf);
            foreach ($lines as &$line) {
                ++$linenum;
                $contents[] = $line;
                $ln = ltrim($line);
                if ('' === $ln) continue;
                $matches = null;
                $ret = $this->parseLine($ln,$matches);
                if (false === $ret) {
                    echo 'warning: error line at line ', $linenum, "\n";
                    continue;
                }
                if (null === $matches)    continue;
                if (defined($matches['name'])) {
                    echo 'warning: [', $matches['name'], '] existed before at line', $linenum, "\n";
                    continue;
                }
                if (!isset($matches['value'])) {
                    $matches['value'] = null;
                }
                define($matches['name'], $matches['value']);
                dump($matches);
            }
        }
        $contents[] = $rem;
        fclose($fp);
        $this->contents = &$contents;
        $this->linenum = $linenum;
    }
    private function parseLine($ln, &$matches = null) {
        $npos = strpos($ln, '#');
        if (false !== $npos) {
            $ln = substr($ln, 0, $npos);
            if ('' === $ln) return true;
        }
        $eqpos = strpos($ln, '=');
        if(false === $eqpos) return false;
        $name = rtrim(substr($ln, 0, $eqpos));
        if ('' === $name) return false;
        $matches['name'] = &$name;
        //don't use trim here
        $value = substr($ln, $eqpos + 1);
        $matches['value'] = &$value;
        return true;
    }
}