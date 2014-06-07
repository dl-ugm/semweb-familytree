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

    $sparql = new EasyRdf_Sparql_Client('http://localhost:3030/testing/query');
    $input = (isset($_POST['nama'])) ? $_POST['nama'] : 'bob';
    $result = $sparql->query(
        'SELECT ?nama ?ayah ?ibu ?spouse ?anak '.
        'WHERE {'.
        '   ?s rdf:type f:Person .'.
        '   ?s f:name ?nama .' .
        '   FILTER regex(?nama,"'.$input.'","i") .' .
        '   FILTER regex(?s,"'.$input.'","i") .' .
        '   OPTIONAL { ?ayah f:hasChild ?s . ?ayah rdf:type f:Male . }'.
        '   OPTIONAL { ?ibu f:hasChild ?s . ?ibu rdf:type f:Female . }'.
        '   OPTIONAL { ?s f:hasSpouse ?spouse . } ' .
        '   OPTIONAL { ?s f:hasChild ?anak . } ' .
        '}'
    );
    function clean($str){
        return str_replace('http://dl-ugm.com/family_example#', '', $str);
    }
    $child = [];
    // die(var_dump('<pre>'.$result.'</pre>'));
    foreach($result as $row):
        $nama   = $row->s;
        $ayah   = (isset($row->ayah)) ? $row->ayah : '?';
        $ibu    = (isset($row->ibu)) ? $row->ibu : '?';
        $spouse = (isset($row->spouse)) ? $row->spouse : '?';
        $ayah   = clean($ayah);
        $ibu    = clean($ibu);
        $spouse = clean($spouse);
        if(isset($row->anak)):
            $child[] = clean($row->anak);
        endif;
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
        <th>Nama Suami/Istri</th>
        <td><?php echo $spouse; ?></td>
    </tr>
</table>
<!-- <p>Total number of data: <?= $result->numRows() ?></p> -->

 <div class="tree">
    <ul>
        <li>
            <a href="#">
                <div class="people">
                    <?php echo (isset($ayah)) ? $ayah : '?'; ?>
                </div>
                <div class="people">
                    <?php echo (isset($ibu)) ? $ibu : '?'; ?>
                </div>
            </a>
            <ul>
                <li>
                    <a href="#">
                        <div class="people active">
                            <?php echo $nama; ?>
                        </div>
                        <div class="people">
                            <?php echo (isset($spouse)) ? $spouse : '?'; ?>
                        </div>
                    </a>
                    <?php if(count($child)>0): ?>
                        <ul>
                            <?php foreach($child as $a): ?>
                                <li><a href="#"><?php echo $a; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>
        </li>
    </ul>
</div>