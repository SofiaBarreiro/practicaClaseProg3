 <?php


print "hola mundo";
echo "<h1>me permite imprimir<h1>", "<h2>mas de un resultado<h2>";

$variables = 9;
echo $variables;

#para crear comentarios lo puedo hacer con un numeral
#las variables boleanas aparecen como 1 si son verdaderas pero si son falsas aparecen vacias, no aparece el cero

echo "hola<br><br>hola2"; #esto significa que es un salto de linea


#para agregar un array


$nombreVariable = array("elemento1", "elemento2", "elemento3");
echo "el elemento 0 es el $nombreVariable[0]";


#para declarar objetos


$nuevoObjeto = (object)["fruta1"=>"pera"];#para declarar un  objeto primero tengo que agregar la funcion objeto como hice con la de array
#le pongo parentesis a objeto a diferencia de array y despues entre corchetes le indico los valores a los atributos de ese objeto. 
#el obejto es verduleria y le agrego un atributo que es fruta1 el valor de fruta1 es pera

echo "<br><br>esto es para imprimir los valores de los objetos $nuevoObjeto->fruta1";

?>  