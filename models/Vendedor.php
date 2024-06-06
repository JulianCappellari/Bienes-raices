<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla ='vendedores'; 
    protected static $columnasDB = ['id','nombre' , 'apellido' , 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
    public function validar(){
        if(!$this->nombre) {
            self::$errores[] = "Tienes que poner un nombre";
        }
        if(!$this->apellido) {
            self::$errores[] = "Tienes que poner un apellido";
        }
        if(!$this->telefono) {
            self::$errores[] = "Tienes que poner un numero de telefono";
        }

        if(!preg_match('/[0-9]{10}/', $this->telefono)){
            self::$errores[] = "Formato no valido";
        }
        return self::$errores;
    }

}