<?php

include_once "..\LISTAALUMNOS\AccesoDatos.php";



class Alumno
{

    public $nombre;

    public $apellido;

    public $edad;

    public $legajo;

    public $id;


    function __construct($nombre, $apellido, $legajo, $edad, $id){



    }


    public static function TraerTodoLosAlumnos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,edad as edad, legajo as legajo from Alumno");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "alumno");
    }

    public static function TraerUnAlumno($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,edad as edad, legajo as legajo from alumno where id = $id");
        $consulta->execute();
        $alumnoBuscado = $consulta->fetchObject('alumno');
        return $alumnoBuscado;
    }

    public function InsertarElAlumno()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into Alumno (nombre,apellido,edad,legajo)values('$this->nombre','$this->apellido','$this->edad','$this->legajo')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }


    public function ModificarAlumno()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("
               UPDATE Alumno 
               SET nombre = '$this->nombre',
               apellido = '$this->apellido',
               edad= '$this->edad',
               legajo= '$this->legajo'
               WHERE id = '$this->id'");



        return $consulta->execute();
    }

    public function BorrarUnAlumno()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				delete 
				from alumno 				
				WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }


    public function mostrarDatos()
    {
        return "Metodo mostar:" . $this->nombre . "  " . $this->apellido . "  " . $this->edad . " " . $this->legajo . "";
    }

    public static function TraerUnAlumnoLegajo($id, $legajo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select  nombre as nombre, apellido as apellido, edad as edad from alumno  WHERE id=? AND legajo=?");
        $consulta->execute(array($id, $legajo));
        $alumnoBuscado = $consulta->fetchObject('alumno');
        return $alumnoBuscado;
    }

    public static function TraerUnAlumnonParamNombre($id, $legajo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select  nombre as nombre, apellido as apellido,edad as edad from alumno  WHERE id=:id AND legajo=:legajo");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':legajo', $legajo, PDO::PARAM_INT);
        $consulta->execute();
        $alumnoBuscado = $consulta->fetchObject('alumno');
        return $alumnoBuscado;
    }



    private $pathJson = "..\LISTAALUMNOS\Listado_de_Alumnos.json";

    private $pathJson2 = "..\LISTAALUMNOS\Listado_de_Alumnos_a.json";

    private $pathTxt = "..\LISTAALUMNOS\Listado_de_Alumnos.txt";

    private $pathXml = "..\LISTAALUMNOS\Listado_de_Alumnos.xml";



    public function SaveAsJSON($id)
    {
        $alumnoS = new Alumno();
        $myfile = fopen($alumnoS->pathJson, "r");

        $jsonNuevo = $alumnoS->retornarJSON($id);

        $myfile = fopen($alumnoS->pathJson, "a+");

        fwrite($myfile, $jsonNuevo . "\n");

        fclose($myfile);
    }

    public function SaveAsJSONArray()

    {

        $nuevoAlumnoJson = $this->retornarJSONArray();

        $arrayJson = json_decode($nuevoAlumnoJson);

        $myfile = fopen($this->pathJson2, "r");

        $contenidoJson = stream_get_contents($myfile);

        $claseAux = new stdclass();

        $json_decoded = json_decode($contenidoJson);



        if (isset($json_decoded)) {

            foreach ($arrayJson as $key => $value) {

                $claseAux->$key = $value;
            }



            array_push($json_decoded, $claseAux);

            fclose($myfile);



            $myfile = fopen($this->pathJson2, "w+");

            fwrite($myfile, "");

            fclose($myfile);



            $myfile = fopen($this->pathJson2, "a");



            for ($i = 0; $i < count($json_decoded); $i++) {



                $jsonArray_1 = json_encode($json_decoded[$i]);



                if ($i == 0) {

                    echo "[" . $jsonArray_1 . "," . "\n";

                    fwrite($myfile, "[" . $jsonArray_1 . "," . "\n");
                } else if ($i + 1 == count($json_decoded)) {

                    echo $jsonArray_1 . "]" . "\n";

                    fwrite($myfile, $jsonArray_1 . "]" . "\n");
                } else {

                    echo $jsonArray_1 . "," . "\n";

                    fwrite($myfile, $jsonArray_1 . "," . "\n");
                }
            }

            fclose($myfile);
        } else {

            $myfile = fopen($this->pathJson2, "w+");

            fwrite($myfile, "[" . $nuevoAlumnoJson . "]" . "\n");

            echo "[" . $nuevoAlumnoJson . "]" . "\n";

            fclose($myfile);
        }
    }

    function retornarJSON($id)
    {

        $objAlumno = new Alumno();

        $objJson = $objAlumno->TraerUnAlumno($id);
        var_dump($objJson);

        return json_encode($objJson, true);
    }


    function retornarJSONArray()
    {

        $objAlumno = new Alumno();

        $objJson = $objAlumno->TraerTodoLosAlumnos();
        var_dump($objJson);

        return json_encode($objJson, true);
    }

    public function Legajo()
    {

        return $this->legajo;
    }

    public function SaveAsTXT()
    {

        $alumnoTxt = "$this->id , $this->nombre , $this->apellido , $this->edad , $this->legajo";
        $alumnoA = new Alumno();
        $myfileTxt = fopen($alumnoA->pathTxt, "a+");

        fwrite($myfileTxt, $alumnoTxt . "\n");

        fclose($myfileTxt);
    }


    //         //Obtengo el Alumno Actual

    //         //Abro el Archivo en modo lectura unicamente para obtener los datos y trabajarlos como un array de clases std

    //         //El Alumno actual lo transformo en clase std y lo agrego al array que obtengo del archivo (Como array de clases porque al hacerle json_decode del get_content lo devuelve así array(stdclass))

    //         //Cierro el archivo y lo vuelvo a abrir para vaciarlo (En caso de falla deberia guardarlo en un bkp)

    //         //Vuelvo a abrir el archivo en modo append para lopear el array e ir agregando todos los elementos, incluso el nuevo

    //         //Cierro el archivo




    public function SaveInXML($alumnoXml)
    {
        $xml = new DomDocument('1.0', 'UTF-8');
        $xml = $this->CrearObjetoXml($alumnoXml, $xml);
        $gestor = fopen($alumnoXml->pathXml, 'a+');

        var_dump($el_xml = $xml->saveXML());
        fwrite($gestor, $el_xml);
        fclose($gestor);
    }



    public function SaveInXMLArray($alumnoXml)
    {
        $xml = new DomDocument('1.0', 'UTF-8');
        $gestor = fopen($alumnoXml->pathXml, 'a+');
        $alumnoAux = new Alumno();

        foreach ($alumnoXml as $alumnoAux){

            if(isset($alumnoAux)){

            $xml = $this->CrearObjetoXml($alumnoAux, $xml);
            var_dump($xml);

            $el_xml = $xml->saveXML();
            fwrite($gestor, $el_xml);
            }
            
        }

        fclose($gestor);
    }

    public function CrearObjetoXml($alumnoXml, $xml)
    {


        $CAlumno = $xml->createElement('Alumno');
        $CAlumno = $xml->appendChild($CAlumno);


        $CAlumno->setAttribute('nombre', 'apellido', 'edad', 'legajo', 'id');

        $nombreXml = $xml->createElement('nombre', $alumnoXml->nombre);
        $nombreXml = $CAlumno->appendChild($nombreXml);


        $apellidoXml = $xml->createElement('apellido', $alumnoXml->apellido);
        $apellidoXml = $CAlumno->appendChild($apellidoXml);

        $edadXml = $xml->createElement('edad', $alumnoXml->edad);
        $edadXml = $CAlumno->appendChild($edadXml);

        $legajoXml = $xml->createElement('legajo', $alumnoXml->legajo);
        $legajoXml = $CAlumno->appendChild($legajoXml);

        $idXml = $xml->createElement('id', $alumnoXml->id);
        $idXml = $CAlumno->appendChild($idXml);

        $xml->formatOutput = true;

        return $xml;
    }
}






//     public function GuardarFoto($file)

//     {

//         // $target_dir = "./Fotos/";

//         // $file1 = $file['imagen']['name'];

//         // $path = pathinfo($file1);

// 	    // $filename = $path['filename'];

//         // $ext = $path['extension'];



//         //fotos -> legajo.Apellido.png

//         //fotosbkp-> " + fecha.png

//         //guardar foto y guardarbkp 



//         var_dump($file);

//         $temp_name = $file['tmp_name'];



//         // if($file['name'])

//         // $dh = opendir("./Fotos/");

//         // var_dump($dh);

//             // if($dh = opendir("./Fotos")){

//             //   while (($filedir = readdir($dh)) !== false){

//             //     if($filedir == $file["name"])

//             //     {

//             //         // var_dump($filedir);

//             //         echo 'archivo encontrado';

//             //         $fotoEncontrada = fopen("./Fotos/". $filedir,"r");

//             //          $fileinfo = pathinfo($fotoEncontrada);

//             //         var_dump($fileinfo);

//             //         copy($fotoEncontrada,"./FotosBkp");

//             //     }

//             //   }

//             //   closedir($dh);

//             // }



//             $files = scandir('./Fotos/');

//             $destination = './FotosBkp/';

//             $date = date('d-m-Y');

//         foreach($files as $archivo){

            

//                 var_dump($archivo);

            

//             $rename_file = $destination.$archivo.'_'.$date;

//             rename($archivo, $rename_file);

//         }

//     }



// function MarcaDeAgua($file)

// {

//     // Cargar la estampa y la foto para aplicarle la marca de agua

// $estampa = imagecreatefrompng('./Fotos/hurricane.png');

// $im = $file;

// $temp_name = $file['tmp_name'];

// echo 'marca de agua';



// var_dump($estampa);



// // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa

// $margen_dcho = 10;

// $margen_inf = 10;

// $sx = imagesx($estampa);

// $sy = imagesy($estampa);



// // Copiar la imagen de la estampa sobre nuestra foto usando los índices de márgen y el

// // ancho de la foto para calcular la posición de la estampa. 

// imagecopy($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa));



// // // Imprimir y liberar memoria

// // header('Content-type: image/png');

// // imagepng($im);

// // imagedestroy($im);



// move_uploaded_file($im,"./Fotos/".$file["name"]);

//     }

// }
