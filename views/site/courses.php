<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSeach */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;

$count = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$rowOnPage = 10;
$finishCount = $page * $rowOnPage;
$startCount = $finishCount - $rowOnPage;

?>

    <table class="table table-striped">
        <thead>
        <tr>
            <?php
            foreach ($categories as $category) { ?>
                <td><a href="courses?id=<?= $category['id'] ?>"><?= $category['name'] ?></a></td>
                <?php
                /*
                echo "<a href='bitmedia/site/courses?id=<?". $category['id'] . " > ";
                echo "<th scope=\'col\'>";
                //echo "<a href='bitmedia/site/courses?id=<?". $category['id'] . " > ";
                echo  $category['name'];

                echo "</th></a>";*/
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            foreach ($categories as $category) {
                //print_r($category['image']);
                echo '<td> ';
                //echo "<img src='/web/uploads/".$category['image']."/>";

                //echo Html::img(Yii::getAlias('web\uploads\\' . $category['image']));
                ?>
                <?= Html::img(Url::to('@web/uploads/' . $category['image'])) ?>
                <?php


                echo '</td>';
            }
            ?>
        </tr>
        </tbody>
    </table>

<?php
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';

echo '<br>';
echo '<tr>';
echo '<table class="table table-striped"><thead>';
foreach ($titles as $title) {
    echo "<th scope=\'col\'>" . $title . "</th>";
}


echo '</tr></thead><tbody>';
if (isset($_GET['id'])) {
    $current_category = $_GET['id'];
    for ($i = 0; $i < count($fields); $i++) {
        for ($k = 0; $k < count($categories_course); $k++) {
            if ($current_category == $categories_course[$k]['category_id']) {
                $fields[$i] = array_values($fields[$i]);
                if ($fields[$i][3] == $categories_course[$k]['course_id']) {
                    $count++;
                    if ($count <= $startCount or $count >= $finishCount+1) {
                        continue;
                    }
                    echo "<tr>";
                    //echo '<th scope="row">' . $i + 1 . '</th>';
                    echo '<th scope="row">' . $count . '</th>';
                    for ($j = 0; $j < count($titles) - 1; $j++) {
                        echo "<td>";
                        echo $fields[$i][$j];
                        echo "</td>";
                    }
                    break;
                }
            }
        }

    }
} else {
    for ($i = 0; $i < count($fields); $i++) {
        $count++;
        if ($count <= $startCount or $count >= $finishCount+1) {
            continue;
        }
        echo "<tr>";

        //echo '<th scope="row">' . $i + 1 . '</th>';
        echo '<th scope="row">' . $count . '</th>';
        $fields[$i] = array_values($fields[$i]);

        for ($j = 0; $j < count($titles) - 1; $j++) {
            echo "<td>";
            echo $fields[$i][$j];
            echo "</td>";
        }
    }
}


echo "</tbody></table>";
$countPage = 1;

echo '<br>';
if (count($fields) > $rowOnPage)

    while(($countPage-1)*$rowOnPage < $count) {
        if (isset($_GET['id'])) {
            echo '<a href="courses?' . 'id=' . $current_category . '&page=' . $countPage . '">' . $countPage . "</a>";
            echo "     ";
            $countPage++;
        } else {
            echo '<a href="courses?&page=' . $countPage . '">' . $countPage . "</a>";
            echo "     ";
            $countPage++;
        }



    }


?>