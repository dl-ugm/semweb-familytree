<?php
require 'vendor/autoload.php';
/**
 * Get family info based on query inserted
 * @author Rijalul Fikri, Diah Sekar Sari R, Fendy Tricahyono, Cahyo W.
 */
    /**
     * Making a SPARQL SELECT query
     *
     * This example creates a new SPARQL client, pointing at the
     * dbpedia.org endpoint. It then makes a SELECT query that
     * returns all of the countries in DBpedia along with an
     * english label.
     *
     * Note how the namespace prefix declarations are automatically
     * added to the query.
     *
     * @package    EasyRdf
     * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
     * @license    http://unlicense.org/
     */

    // set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
    // require_once "EasyRdf.php";
    // require_once "html_tag_helpers.php";

    // Setup some additional prefixes for DBpedia
    EasyRdf_Namespace::set('category', 'http://dbpedia.org/resource/Category:');
    EasyRdf_Namespace::set('dbpedia', 'http://dbpedia.org/resource/');
    EasyRdf_Namespace::set('dbo', 'http://dbpedia.org/ontology/');
    EasyRdf_Namespace::set('dbp', 'http://dbpedia.org/property/');
    EasyRdf_Namespace::set('f', 'http://dl-ugm.com/family_example#');

    $sparql = new EasyRdf_Sparql_Client('http://localhost:3030/dataset/query');
    $input = (isset($_POST['nama'])) ? $_POST['nama'] : 'bob';
    $result = $sparql->query( // 'SELECT ?s ?ayah ?ibu ?spouse WHERE { ?s rdf:type f:Person . ?s f:name ?nama . ?ayah f:hasChild ?s . ?ayah rdf:type f:Male . ?ibu f:hasChild ?s . ?ibu rdf:type f:Female . ?s f:hasSpouse ?spouse . FILTER regex(?nama,"'.$input.'","i") }'
        'SELECT ?s ?ayah ?ibu ?spouse '.
        'WHERE {'.
        '   ?s rdf:type f:Person .'.
        '   ?ayah f:hasChild ?s .'.
        '   ?ayah rdf:type f:Male .'.
        '   ?ibu f:hasChild ?s .'.
        '   ?ibu rdf:type f:Female .'.
        '   ?s f:name ?nama .' .
        // '   ?s f:hasSpouse ?spouse .' .
        '   FILTER regex(?nama,"'.$input.'","i") .' .
        '   OPTIONAL { ?s f:hasSpouse ?spouse . } '.
        '}'
    );
    foreach($result as $row):
        // echo $row->s.'-'.$row->p.'-'.$row->o.'<br>';
        $ayah = $row->ayah;
        $ibu = $row->ibu;
        $spouse = $row->spouse;
    endforeach;
?>
<table>
    <tr>
        <th colspan="2">Data detail for "<?php echo $input; ?>"</th>
    </tr>
    <tr>
        <th>Nama Ayah</th>
        <td><?php echo $ayah; ?></td>
    </tr>
    <tr>
        <th>Nama Ibu</th>
        <td><?php echo $ibu; ?></td>
    </tr>
    <tr>
        <th>Nama Pasangan</th>
        <td><?php echo $spouse; ?></td>
    </tr>
</table>
<p>Total number of data: <?= $result->numRows() ?></p>