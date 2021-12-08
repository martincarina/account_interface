<?php
echo "<ul class='paging'>";

// ссылка для первой страницы 
if ($page > 1) {
    echo "<li><a href='{$page_url}' title='Go to the first page.'>";
    echo "First ";
    echo "</a></li>";
}

// подсчёт общего количества страниц 
$total_pages = ceil($total_rows / $accounts_per_page);

// диапазон ссылок для отображения 
$range = 2;

// отображать ссылки на «диапазон страниц» вокруг «текущей страницы» 
$initial_num = $page - $range;
$condition_limit_num = ($page + $range) + 1;

for ($i = $initial_num; $i < $condition_limit_num; $i++) {

    // убедимся, что '$i больше 0' и 'меньше или равно $total_pages' 
    if (($i > 0) && ($i <= $total_pages)) {

        // текущая страница 
        if ($i == $page) {
            echo "<li class ='current'><a href=\"#\">$i</a></li>";
        }

        // НЕ текущая страница 
        else {
            echo "<li><a href='{$page_url}page=$i'>$i</a></li>";
        }
    }
}

// ссылка на последнюю страницу 
if ($page < $total_pages) {
    echo "<li><a href='" . $page_url . "page={$total_pages}' title='Last page from {$total_pages}.'>";
    echo "Last";
    echo "</a></li>";
}

echo "</ul>";