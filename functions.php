<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function buildTree($items) {
    $childs = array();
    foreach ($items as &$item)
        $childs[$item['parent_id']][] = &$item;
    unset($item);
    foreach ($items as &$item)
        if (isset($childs[$item['id']]))
            $item['childs'] = $childs[$item['id']];
    return $childs[0];
}

function recursiveWrite($array) {
    foreach ($array as $vals) {
        $_SESSION['recursion_code'] .= '<ul>';
        $_SESSION['recursion_code'] .= '<li style="list-style:none">' . $vals['value'] . "\n" . '</li>';
        if (isset($vals['childs'])) {
            RecursiveWrite($vals['childs'], $_SESSION['recursion_code']);
        }
        $_SESSION['recursion_code'] .= '</ul>';
    }
}

function iterativeWrite($array) {
    $html = "";
    foreach ($array as $val0) {
        $html .= '<ul>';
        $html .= '<li style="list-style:none">' . $val0['value'] . "\n" . '</li>';
        if (isset($val0['childs'])) {
            foreach ($val0['childs'] as $val1) {
                $html .= '<ul>';
                $html .= '<li style="list-style:none">' . $val1['value'] . "\n" . '</li>';
                if (isset($val1['childs'])) {
                    foreach ($val1['childs'] as $val2) {
                        $html .= '<ul>';
                        $html .= '<li style="list-style:none">' . $val2['value'] . "\n" . '</li>';
                        if (isset($val2['childs'])) {
                            foreach ($val2['childs'] as $val3) {
                                $html .= '<ul>';
                                $html .= '<li style="list-style:none">' . $val3['value'] . "\n" . '</li>';
                                if (isset($val3['childs'])) {
                                    foreach ($val3['childs'] as $val4) {
                                        $html .= '<ul>';
                                        $html .= '<li style="list-style:none">' . $val4['value'] . "\n" . '</li>';
                                    }
                                }
                                $html .= '</ul>';
                            }
                        }
                        $html .= '</ul>';
                    }
                }
                $html .= '</ul>';
            }
        }
        $html .= '</ul>';
        $html .= '</ul>';
    }
    return $html;
}

session_start();
if (!array_key_exists('cat', $_SESSION)) {
    $_SESSION['cat'] = array();
    $_SESSION['max_id'] = 0;
    $_SESSION['recursion_code'] = "";
}

function add_new_categories() {

    $categories_array = $_POST['category-title'];
    if ($categories_array != "") {
        $numeric = 0;
        $id = 0;
        $categories_id = $_POST['category-id'];
        $categories_parent = $_POST['category-parent'];
        foreach ($categories_array as $single_category) {
            $parent_id = 0;
            if ($categories_id[$numeric] == 1) {
                $parent_id = 0;
                $id = $_SESSION['max_id'] + 1;
                $_SESSION['max_id'] ++;
            } elseif ($categories_id[$numeric] <= $_SESSION['max_id']) {
                $parent_id = ($_SESSION['max_id'] + 1) - $categories_id[$numeric] + 1;
                $id = $_SESSION['max_id'] + 1;
                $_SESSION['max_id'] ++;
            } else {
                $id = $categories_id[$numeric];
                $_SESSION['max_id'] = $id;
                $parent_id = $categories_parent[$numeric];
            }
            if ($single_category != "") {
                $_SESSION['cat'][] = array(
                    'id' => $id,
                    'parent_id' => $parent_id,
                    'value' => $single_category
                );
                $numeric++;
            }
        }
    }
}

if (isset($_REQUEST['submit'])) {
    add_new_categories();
    $_SESSION['recursion_code'] = "";
    print_result();
}

function print_result() {
    $html = "";
    $html .= '<div class="categories-list"><div class="categories-recursive"><h3>Categories recursive</h3>';
    if (count($_SESSION['cat']) > 0) {
        $tree = buildTree($_SESSION['cat']);
        recursiveWrite($tree);
        $html .= $_SESSION['recursion_code'];
    } else {
        $html .= 'Categories tree is empty';
    }
    $html .= '</div><div class="categories-space"></div><div class="categories-iterative"><h3>Categories iterative</h3>';
    if (count($_SESSION['cat']) > 0) {
        $tree = buildTree($_SESSION['cat']);
        $html .= iterativeWrite($tree);
    } else {
        $html .= 'Categories tree is empty';
    }
    $html .= '</div></div>';
    echo $html;
}

//session_unset();


