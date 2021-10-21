<?php include("template/cabecera.php"); ?>
<div class="p-5 bg-light">
    <div class="container">
        <h1 class="display-3">Jumbo heading</h1>
        <p class="lead">Jumbo helper text</p>
        <hr class="my-2">
        <p>More info</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
        </p>
    </div>
</div>
<?php include("template/pie.php"); ?>

<?php  


function distancia($x1, $y1, $x2, $y2){
    $dis =sqrt(pow($x2-$x1,2)+pow($y2-$y1,2));
    return $dis;
}

$x1=1;
$y1 =1;
$x2=2;
$y2=4;
$x3=3;
$y3=2;

$dp1p2=distancia($x1,$y1,$x2,$y2);
$dp1p3=distancia($x1,$y1,$x3,$y3);
$dp2p3=distancia($x2,$y2,$x3,$y3);
$promediodistancia=($dp1p2+$dp1p3+$dp2p3)/3;
echo "la disancia es : $promediodistancia";

function repetidos($a)
{
    if (!is_array($a)) return null;

    $repetido= array_count_values($a);
    $maximo_repetido = array_search(max($repetido),$repetido);
    return $maximo_repetido;
    
}

//$poplar= array(34,31,34,77,82);
$poplar= array(14,14,2342,2342,2342,5);

echo " el mas repetido es:". repetidos($poplar);
//print_r(repetidos($poplar));


function ajustar($palabra, $a, $ra, $b , $rb){
    $p1 = str_replace($a,$ra,$palabra);
    $p2 =str_replace($b,$rb,$p1);

    return $p2;
}

$palabra = "abccfg";
$a="f";
$ra = "b";
$b="g";
$rb="a";

$remplazar = ajustar($palabra, $a, $ra, $b , $rb);

echo " se ajusto la palabra $palabra a :".$remplazar;

?>
