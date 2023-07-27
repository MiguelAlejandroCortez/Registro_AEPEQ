<?php

#clase
class Conexion
{
    #Atributos
    private $host; //LocalHost o IP
    private $db; //nombre de la BD -> usuarios
    private $usuario; //usuario de la BD -> root
    private $pass; //Contraseña del usuario
    private $charset; //utf8

    #constructor
    public function __construct()
    {
        $this->host = 'localhost';
        $this->db = 'aepeq';
        $this->usuario = 'root';
        $this->pass = '';
        $this->charset = 'utf8';
    }

    #Metodo Conectar
    public function conectar()
    {

        #Conectar a la BD -> PDO
        $com = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
        $enlace = new PDO($com,$this->usuario, $this->pass);
        #print_r($enlace);
        return $enlace;
    }

}
?>