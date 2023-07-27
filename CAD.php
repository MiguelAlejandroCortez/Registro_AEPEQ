<?php

require_once "conectar.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class CAD
{

    public $con;

    static public function agregaUsuario($nombre, $apellido, $contraseña, $correo, $Certificado, $Comprobante, $celular, $estado, $pais, $ocupacion, $LugarTrabajo, $colegio)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("INSERT INTO tusuario (Nombre, Apellido, Email, Contraseña, Celular, Estado, Pais, Ocupacion, Lugar_Trabajo, Colegio_asociacion, Certificado_Socio, Comprobante_Pago) 
        VALUES ('$nombre', '$apellido', '$correo', '$contraseña', '$celular', '$estado', '$pais', '$ocupacion', '$LugarTrabajo', '$colegio', '$Certificado', '$Comprobante')");
    
        if ($query->execute()) {
            echo "El usuario $correo se ha agregado correctamente";
            return 1;
        } else {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }
    

    static public function agregaAdministrador($nombre, $contraseña, $correo) //funcional se llama en registroCliente
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("INSERT INTO administrador (nombre, correoe, contraseña) VALUES ('$nombre', '$correo', '$contraseña')");

        if ($query->execute()) {
            $_SESSION['rol'] = 3; 
            echo "El usuario $nombre se ha agregado correctamente";
            return 1;
        } else {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }

    static public function verificaCorreoRegistrado($correo)//funcional se llama en registroCliente
    {
        $con = new Conexion();
        $queryUsuario = $con->conectar()->prepare("SELECT COUNT(*) FROM tusuario WHERE Email = '$correo'");

        if($queryUsuario->execute()){
            $countUsuario = $queryUsuario->fetchColumn();

            if($countUsuario > 0){
                return true; // El correo ya está registrado en vendedor o usuario
            }else{
                return false; // El correo no está registrado en vendedor ni usuario
            }
        }else{
            return false; // Error en la consulta
        }
    }

    static public function verificaUsuario($nombre, $contraseña)
    {
        $con = new Conexion();

        // Verificar en la tabla de usuarios
        $query = $con->conectar()->prepare("SELECT * FROM usuario WHERE nombre = '$nombre' AND contraseña = '$contraseña'");
    
        if ($query->execute()) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $_SESSION['idUsuario'] = $row['idUsuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['rol'] = $row['rol']; // Asignar el valor del campo "rol" al iniciar sesión
                return true;
            }
        }

        // Verificar en la tabla de vendedores
        $queryVendedor = $con->conectar()->prepare("SELECT * FROM vendedor WHERE nombre = '$nombre' AND contraseña = '$contraseña'");

        if($queryVendedor->execute()){
            $rowVendedor = $queryVendedor->fetch(PDO::FETCH_ASSOC);
            if($rowVendedor){
                $_SESSION['IdVendedor'] = $rowVendedor['IdVendedor'];
                $_SESSION['nombre'] = $rowVendedor['nombre'];
                $_SESSION['rol'] = 1; // Rol de vendedor
                return true;
            }
        }

        // Verificar en la tabla de administradores
        $queryAdmin = $con->conectar()->prepare("SELECT * FROM administrador WHERE nombre = '$nombre' AND contraseña = '$contraseña'");

        if($queryAdmin->execute()){
            $rowAdmin = $queryAdmin->fetch(PDO::FETCH_ASSOC);
            if($rowAdmin){
                $_SESSION['idAdmi'] = $rowVendedor['idAdmi'];
                $_SESSION['nombre'] = $rowVendedor['nombre'];
                $_SESSION['rol'] = 3; // Rol de vendedor
                return true;
            }
        }

        return false; 
    }

    static public function verificaUsuarioCorreo($nombre, $correo)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM usuario WHERE nombre = '$nombre' AND correoe = '$correo'");
        if ($query->execute()) {
            $row = $query->fetch(PDO::FETCH_NUM);
            if ($row) {
                $_SESSION['idUsuario'] = $row[0];
                return true;
            }
        }

        $query = $con->conectar()->prepare("SELECT * FROM vendedor WHERE nombre = '$nombre' AND correoe = '$correo'");
        if ($query->execute()) {
            $row = $query->fetch(PDO::FETCH_NUM);
            if ($row) {
                $_SESSION['IdVendedor'] = $row[0];
                return true;
            }
        }

        return false;
    }

    static public function modificaUsuario($datosModificar,$idUsuario) //se llama en actualiza
    {
        $con = new Conexion(); //Establecer la conexion a la BD
        $query = $con->conectar()->prepare("UPDATE usuario SET $datosModificar WHERE idUsuario = $idUsuario");

        if($query->execute())
        {
             return 1;
        }
        else
        {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }

    }

    static public function traeUsuarios() //se llama en elimina
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM usuario ORDER BY nombre DESC");
        if($query->execute())
        {
            $datos = [];
            /*Mas de un registro*/
            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $datos[] =$row;
            }
            #print_r($datos);
            return $datos;
        }
        else
        {
            return false;
        }
    }

    static public function traeTodosVendedores() //se llama en elimina
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM vendedor ORDER BY nombre DESC");
        if($query->execute())
        {
            $datos = [];
            /*Mas de un registro*/
            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $datos[] =$row;
            }
            #print_r($datos);
            return $datos;
        }
        else
        {
            return false;
        }
    }

    static public function traeTodasVentas() //se llama en elimina
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM venta ORDER BY idVenta DESC");
        if($query->execute())
        {
            $datos = [];
            /*Mas de un registro*/
            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $datos[] =$row;
            }
            #print_r($datos);
            return $datos;
        }
        else
        {
            return false;
        }
    }


    public function traeUsuarioPorId($idUsuario) //se llama en SesionCliente
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM usuario WHERE idUsuario = :idUsuario");
        $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        
        if ($query->execute()) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }


    static public function eliminaUsuario($idUsuario) //se llama en elimina
    {
        $con = new Conexion(); //Establecer la conexion a la BD
        $query = $con->conectar()->prepare("DELETE FROM usuario WHERE idUsuario = $idUsuario");

        if($query->execute())
        {
             return 1;
        }
        else
        {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }

    static public function eliminaVendedor($idVendedor) //se llama en elimina
    {
        $con = new Conexion(); //Establecer la conexion a la BD
        $query = $con->conectar()->prepare("DELETE FROM vendedor WHERE IdVendedor = $idVendedor");

        if($query->execute())
        {
             return 1;
        }
        else
        {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }

    static public function agregaVendedor($nombre, $contraseña, $correo) //funcional se llama en RegistroVendedor
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("INSERT INTO vendedor (nombre, correoe, contraseña) VALUES ('$nombre', '$correo', '$contraseña')");

        if ($query->execute()) {
            $_SESSION['rol'] = 1; 
            echo "El vendedor $nombre se ha agregado correctamente";
            return 1;
        } else {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }

    public function traeUsuarioPorIdVendedor($idVendedor) //se llama en SesionCliente
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM vendedor WHERE IdVendedor = :idVendedor");
        $query->bindParam(':idVendedor', $idVendedor, PDO::PARAM_INT);
        
        if ($query->execute()) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }


    static public function modificaVendedor($datosModificar,$idUsuario) //se llama en actualiza
    {
        $con = new Conexion(); //Establecer la conexion a la BD
        $query = $con->conectar()->prepare("UPDATE vendedor SET $datosModificar WHERE IdVendedor = $idUsuario");

        if($query->execute())
        {
             return 1;
        }
        else
        {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo());
            return 0;
        }

    }

    public function agregaProducto($nombre, $precio, $descripcion, $categoria, $marca, $imagenContent, $idVendedor, $stock)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("INSERT INTO producto (foto, descripcion, precio, nombre, categoria, marca, IdVendedor, stock) VALUES ('$imagenContent', '$descripcion', '$precio', '$nombre', '$categoria', '$marca', '$idVendedor', '$stock')");

        if ($query->execute()) {
            return 1;
        } else {
            echo "Hubo un error al agregar el producto.";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }


    public function traeProductoPorIdVendedor($idVendedor)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM producto WHERE IdVendedor = :idVendedor");
        $query->bindParam(':idVendedor', $idVendedor, PDO::PARAM_INT);

        if($query->execute()){
            $productos = array();

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $productos[] = $row;
            }

            return $productos;
        }else{
            return false;
        }
    }
    
    public function verificaProductoConFoto($marca)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT idProd, nombre, precio, foto FROM producto WHERE marca = :marca");
        $query->bindParam(':marca', $marca, PDO::PARAM_STR);
    
        if ($query->execute()) {
            $productos = array();
    
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = $row;
            }
    
            return $productos;
        } else {
            return false;
        }
    }

    public function traeProductoPorId($idProd) 
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM producto WHERE idProd = :idProd");
        $query->bindParam(':idProd', $idProd, PDO::PARAM_INT);
    
        if ($query->execute()) {
            $producto = $query->fetch(PDO::FETCH_ASSOC);
            return $producto;
        } else {
            return false;
        }
    }


    static public function nuevaVenta($idUsuario, $idProducto)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("INSERT INTO venta (fecha_Venta, idUsuario, idProd) VALUES (NOW(), '$idUsuario', '$idProducto')");

        if($query->execute()){
            return 1;
        } else {
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }

    static public function actualizarMontoUsuario($idUsuario, $nuevoMonto)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("UPDATE usuario SET monto = '$nuevoMonto' WHERE idUsuario = '$idUsuario'");
    
        if($query->execute()){
            return 1;
        }else{
            echo "Hubo un error al actualizar el monto del usuario";
            print_r($con->conectar()->errorInfo());
            return 0;
        }
    }

    static public function actualizarStockProducto($idProducto, $nuevoStock)
{
    $con = new Conexion();
    $query = $con->conectar()->prepare("UPDATE producto SET stock = '$nuevoStock' WHERE idProd = '$idProducto'");

    if ($query->execute()) {
        return true;
    } else {
        echo "Hubo un error al actualizar el stock del producto";
        print_r($con->conectar()->errorInfo());
        return false;
    }
}


    public function eliminarProducto($idProd)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("DELETE FROM producto WHERE idProd = :idProd");
        $query->bindParam(":idProd", $idProd, PDO::PARAM_INT);
    
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    function traeVentasPorIdVendedor($idVendedor) {
        $con = new Conexion();
        $query = "SELECT v.idVenta, v.fecha_venta, v.idUsuario, v.idProd, p.nombre as nombre_producto 
                  FROM venta v
                  INNER JOIN producto p ON v.idProd = p.idProd
                  WHERE p.IdVendedor = :idVendedor";
    
        $stmt = $con->conectar()->prepare($query);
        $stmt->bindParam(':idVendedor', $idVendedor);
        $stmt->execute();
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $ventas;
    }
    
    public function traeComprasPorIdUsuario($idUsuario) {
        $con = new Conexion();
        $query = "SELECT c.fecha_Venta, c.idVenta, p.precio, p.nombre, p.categoria, p.marca, p.foto FROM venta c
                  INNER JOIN producto p ON c.idProd = p.idProd
                  WHERE c.idUsuario = :idUsuario";
        
        $stmt = $con->conectar()->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $compras;
    }
    
    public function eliminarVenta($idVenta)
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("DELETE FROM venta WHERE idVenta = :idVenta");
        $query->bindParam(":idVenta", $idVenta, PDO::PARAM_INT);
    
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
?>