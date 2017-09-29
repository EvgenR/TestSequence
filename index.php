<?php
namespace Test;

class Sequence{
    /**
     * тип последовательности
     * @var type 
     */
    protected $type=null;
    
    /**
     * Последовательность в виде массива
     * @var type 
     */
    protected $data=[];

    /**
     * Перевод строки во внутренний массив
     * @param type $str
     */
    public function get($str)
    {
        $this->type=null;
        $this->data= \explode(',', $str);
    }
    
    
    public function checkArray()
    {
        
        if(count($this->data)===0){
            throw new \Exception('Не передан параметр - строка с данными');
        }
        $count=\count($this->data);
        if($count===1){
            $this->type='Одиночный символ';
            return;
        }
        if(!\is_numeric($this->data[0]) AND !\is_numeric($this->data[1])){
                throw new \Exception('Передана не числовая последовательность');                
            }        

        $aD=$this->data[1]-$this->data[0];
        if($this->data[0]===0){
            $gD=null;
        }else{
            $gD=$this->data[1]/$this->data[0];
        }
        
        
        for($x=2;$count>$x;$x++) {
            if(!is_numeric($this->data[$x])){
                throw new \Exception('Передана не числовая последовательность');                
            }
            if(!is_null($aD) and $aD!=$this->data[$x]-$this->data[$x-1]){
                $aD=null;
            }
            if($this->data[$x-1]===0){
                $gD=null;
            }
            if(!is_null($gD) and $gD!=$this->data[$x]/$this->data[$x-1]){
                $gD=null;
            }
            
        }
        
        $this->type='Простой ряд чисел';
        if($aD>0){
            $this->type='Арифметическая(k='.$aD.') последовательность';
        }
        if($gD>0){
            $this->type='Геометрическая(k='.$gD.') последовательность';
        }        
        if($aD>0 AND $gD>0){
            $this->type='Арифметическая(k='.$aD.') и геометрическая(k='.$gD.')  последовательность';
        }
        
        return;
    }
    
    
    /**
     * Вывод типа послдеовательноссти, хранящейся в классе
     */
    public function echoType()
    {
        if(is_null($this->type)){
            echo 'Последовательность не проверена'.PHP_EOL;
        }
        echo $this->type.PHP_EOL;
    }
    
}


class Main{

    /**
     * Точка входа
     * принимает строку для обработки из аргументов командной строки    
     */
    static public function run()
    {
        
        try {
            global $argv;
            if(!isset($argv[1])){
                 throw new \Exception('Не передан параметр - строка с данными');
            }
            $s= new Sequence();
            $s->get($argv[1]);
            $s->checkArray();
            $s->echoType();
            echo 'OK'.PHP_EOL;
                        
        } catch (\Exception $e) {
            echo $e->getMessage().PHP_EOL;
        }
        }
    
}



Main::run();



