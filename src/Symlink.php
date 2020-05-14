<?php
/**
 * File       symlink.php
 *
 * @package   Symlink
 * @author    Imani Manyara <imani@simtabi.com>
 * @date      May 02-2020 —— 14:16
 * @link      http://imanimanyara.com/
 * @since     2019-02 May
 * @version   1.0
 */

namespace Simtabi;

class Symlink {

    private $destination;
    private $source   = [];
    private $generated = [];
    private $messages  = [];
    private $batchJobs = [];

    public function __construct()
    {

    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setSource($paths)
    {
        $this->source = $paths;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    protected function setGenerated(string $generated, $key)
    {
        $data = $this->generated;
        if (isset($data[$key])){
            array_merge($data[$key], [$generated]);
        }
        $data[$key][]   = $generated;
        $this->generated = $data;
        return $this;
    }

    public function getGenerated(): array
    {
        return $this->generated;
    }

    protected function setMessages(string $messages, $key)
    {
        $data = $this->messages;
        if (isset($data[$key])){
            array_merge($data[$key], [$messages]);
        }
        $data[$key][]   = $messages;
        $this->messages = $data;
        return $this;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function setBatchJobs(array $batchJobs)
    {
        $this->batchJobs = $batchJobs;
        return $this;
    }

    public function getBatchJobs(): array
    {
        return $this->batchJobs;
    }

    private function symlink($source, $destination){

        $source      = trim($source);
        $destination = trim($destination);
        try{

            if (!file_exists($source)){
                $this->setMessages("<strong>".strtoupper($source)." </strong>"." &mdash;source path to create symlinks from does not exist!", 'error');
                return false;
            }

            if (file_exists($destination)){
                $this->setMessages("<strong>".strtoupper($destination)." </strong>"." &mdash;destination to create symlinks to already exist!", 'error');
                return false;
            }

            if (is_link($destination)) {
                $this->setMessages("<strong>'".($destination)."' </strong>"." &mdash;symbolic shortcut link already exists in the given directory/path and could not be recreated!", 'error');
                $this->setGenerated(readlink($destination), 'exists');
            } else {
                if(symlink($source, $destination)){
                    $this->setMessages("<strong>'".($destination)."' </strong>"." &mdash;symbolic shortcut link has been created!", 'success');
                    $this->setGenerated(readlink($destination), 'created');
                }else{
                    $this->setMessages("<strong>'".($source)."' </strong>"." &mdash;symbolic shortcut link could not be created!", 'error');
                    return false;
                }
            }
            return true;
        }catch (Exception $exception){
            $this->setMessages($exception->getMessage(), 'error');
            return false;
        }
    }

    public function generate($echo = true){

        // get directories if defined
        $batches = $this->getBatchJobs();

        // if more directories defined
        if (is_array($batches) && (count($batches) > 0)){

            foreach ($batches as $batch){
                $destination = isset($batch['destination']) ? $batch['destination'] : null;
                $source      = isset($batch['source']) ? $batch['source'] : null;

                if (empty($destination) || !is_string($destination)){
                    $this->setMessages("Destination path can not be empty and must be a string!", 'error');
                }
                if (empty($source) || !is_string($source)){
                    $this->setMessages("Source path can not be empty and must be a string!", 'error');
                }

                if (!empty($source) && !empty($destination)) {
                    $this->symlink($source, $destination);
                }else{
                    $this->setMessages("Symbolic shortcut link source and destination path can not be empty and must be a string!", 'error');
                }
            }
        }
        else{

            $destination = $this->getDestination();
            $source      = $this->getSource();

            if (empty($destination) || !is_string($destination)){
                $this->setMessages("Symbolic shortcut link destination path can not be empty and must be a string!", 'error');
            }

            if (empty($source) || !is_string($source)){
                $this->setMessages("Symbolic shortcut link source path can not be empty and must be a string!", 'error');
            }

            if (!empty($source) && !empty($destination)) {
                $this->symlink($source, $destination);
            }else{
                $this->setMessages("Symbolic shortcut link source and destination path can not be empty and must be a string!", 'error');
            }
        }


        if ($echo){
            $messages = $this->getMessages();
            $html = "<div style='margin: 20%;'>";
            foreach ($messages as $key => $message){
                if ($key == 'success'){
                    $html .= $this->errorMsg($message, 'color: #2ca02c;');
                }
                else if ($key == 'error'){
                    $html .= $this->errorMsg($message, 'color: #d61c23;');
                }
                else{
                    $html .= $this->errorMsg($message, 'color: #393737;');
                }
            }
            $html .= "</div>";
            echo $html;
        }
        return true;
    }

    private function errorMsg($data, $style){
        $html = '';
        if (is_array($data)){
            foreach ($data as $item){
                $html .= "<p style='$style'>" . $item. "</p>";
                if (is_array($item)){
                    $this->errorMsg($item, $style);
                }
            }
        }
        return $html;
    }

}