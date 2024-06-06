<?php



namespace Model;

class ActiveRecord{
    // BD
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla =''; 
    // Validaciones
    protected static $errores = [];

    // Definir la conecxion a la base de datos
    public static function setDB($database){
        self:: $db = $database;
        //Self va en todos los que tenga relacion con la base de datos
    }

    public function guardar(){
        $resultado = '';
        if (!is_null($this->id)) {
            //Actualizar
            $resultado = $this->actualizar();
         } else{
            //Creando un nuevo registro
            $resultado = $this->crear();
         }
        return $resultado;
        
     }

    public function crear() {
        // Sanitizar los datos 
        $atributos = $this->sanitizarDatos();

        $query = " INSERT INTO " .   static::$tabla  ." ( ";
        $query .= join(', ', array_keys($atributos));
        $query .=  " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function actualizar(){
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        $valores= [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query =  " UPDATE " .   static::$tabla  ." SET "; 
        $query .= join(', ' , $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' "; // Cuando son numero no van las comillas simples
        $query .= " LIMIT 1 ";
        
        $resultado = self::$db->query($query);

        return $resultado;
    }

    // Eliminar un registro
    public function eliminar(){
        $query = "DELETE FROM " .   static::$tabla  ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado){
            $this->borrarImagen();
        }
        return $resultado;
    }

    
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($columna ==='id')continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen){
        //Elimina la imagen previa
        if(!is_null($this->id)){
            $this->borrarImagen();
        }

        if($imagen){
            $this->imagen = $imagen;
        }
    }
    // Eliminar archivo de imagen
    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }


    // Validacion
    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        
        static::$errores = [];
        return static::$errores;
    }

    // Lista todas las propiedades
    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Busca una propiedad por su id
    public static function find($id){
        $query = "SELECT * FROM " .   static::$tabla  ." WHERE id = ${id}";

        $resultado = self::consultarSQL($query);

        return array_shift( $resultado);

    }


    public static function consultarSQL($query){
        // Consultar la BD
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }

        //liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Convierte un arreglo en un objeto 
    protected static function crearObjeto($registro){
        $objeto = new static;

        foreach($registro as $key => $value){
            if(property_exists($objeto , $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }


    // Sincronizar el objeto en memoria con los cambios realizados por le usuario
    public function sincronizar( $arreglo = []){
        foreach($arreglo as $key => $value){
            if(property_exists($this, $key) && !is_null($value) ){
                $this->$key = $value;
            }
        }
    }

    // Obtiene un numero determinado de registros
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT "  . $cantidad;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}