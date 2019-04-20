<?php
include_once "..\LISTAALUMNOS\Alumno.php";


// $nAlumno = new Alumno("sofia", "barreiro",45,456);
// $nAlumno = new Alumno();
// var_dump($nAlumno);
// var_dump($nAlumno->TraerTodoLosAlumnos());
//var_dump($nAlumno->TraerUnAlumno(1));
// var_dump($PrimerA->InsertarElAlumno());

// var_dump($PrimerA->MostrarDatos());
// var_dump($PrimerA->TraerUnAlumnoLegajo(2,456)); por que muestra null en el legajo?

// var_dump($PrimerA->TraerUnAlumnonParamNombre(1,343)); que hacen bindvalue y por que da null
//var_dump($PrimerA->ModificarAlumno()); 

// falta lo de la grilla de datos, punto 19

$PrimerA = new Alumno();


$PrimerA->nombre = "sofia";
$PrimerA->apellido = "barreiro";
$PrimerA->edad = 34;
$PrimerA->legajo= 343;
$PrimerA->id =2;


var_dump($PrimerA->guardar());//guardar json

//var_dump($PrimerA->BorrarUnAlumno());




?>