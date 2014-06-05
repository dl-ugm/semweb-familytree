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
    EasyRdf_Namespace::set('f', 'http://dl-ugm.com/family_example/');

    $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
    // $sparql = new EasyRdf_Sparql_Client('http://localhost:8080/openrdf-sesame/repositories/familyexample');
    // $sparql = new EasyRdf_Sparql_Client('http://localhost:8000/family2.owl');
?>
<html>
<head>
  <title>EasyRdf Basic Sparql Example</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>EasyRdf Basic Sparql Example</h1>

<h2>List of countries</h2>
<ul>
<?php
    $result = $sparql->query(
        'SELECT * WHERE {'.
        '  ?country rdf:type dbo:Country .'.
        '  ?country rdfs:label ?label .'.
        '  ?country dc:subject category:Member_states_of_the_United_Nations .'.
        '  FILTER ( lang(?label) = "en" )'.
        '} ORDER BY ?label'
    );
	// $result = $sparql->query('SELECT ?s ?p ?o WHERE { ?s rdf:type f:Person . ?s ?p ?o }');
    // die(var_dump($result));
    // foreach ($result as $row) {
    //     echo "<li>".$row->s, $row->p."</li>\n";
    // }
    foreach ($result as $row) {
        echo "<li>".$row->label.' - '.$row->country."</li>\n";
    }
?>
</ul>
<p>Total number of countries: <?= $result->numRows() ?></p>

</body>
</html>