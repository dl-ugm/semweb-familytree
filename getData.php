<?php
require 'vendor/autoload.php';

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
    // EasyRdf_Namespace::set('f', 'http://dl-ugm.com/family_example/');

    $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
    $query = 'SELECT * WHERE {'.
        '  ?country rdf:type dbo:Country .'.
        '  ?country rdfs:label ?label .'.
        '  ?country dc:subject category:Member_states_of_the_United_Nations .'.
        '  FILTER ( lang(?label) = "en" )'.
        '} ORDER BY ?label';

    if(isset($_POST['theVar'])){
        $theVars = explode(" ", $_POST['theVar']);
        foreach($theVars as $d){
            $theVar[] = $d;
        }
    }else{
        $theVar = ['label','country'];
    }
    $input = (isset($_POST['query']) ? $query=$_POST['query'] : $query);
    
    $result = $sparql->query($query);
    // return var_dump($result);
    // foreach ($result as $row) {
    //     echo "<li>".$row->label.' - '.$row->country."</li>\n";
    // }
?>
<table>
    <thead>
        <tr>
            <?php foreach($theVar as $d): ?>
            <th><?php echo strtoupper($d); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($result as $row): ?>
        <tr>
            <?php foreach($theVar as $d): ?>
            <td>
                <?php
                $data = str_replace('http://dbpedia.org/resource/', '', $row->$d);
                $data = str_replace('http://dbpedia.org/ontology/', '', $data);
                echo $data; 
                ?>
            </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>