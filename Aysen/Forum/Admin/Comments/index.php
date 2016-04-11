<?php
require ('../../../database.php');
require('../../Model/comment.php');
require('../../Model/comment_db.php');
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'list_comments';
}
if ($action == 'list_comments') {
    // Get comment and comment data
    $comments = commentDB::getComments();

    // Display the comment list
    include('comment_list.php');
}
else if ($action == 'delete_comment') {
    // Get the IDs
    $comment_id = $_POST['comment_id'];
    // Delete the comment
    commentDB::deleteComment($comment_id);

    // Display the comment List page for the current comment
    header("Location: .?");
}
else if ($action == 'show_add_form') {
    //echo $action;
    $comments = commentDB::getComments();
    include('comment_add.php');
}
else if ($action == 'add_comment') {
    $name = $_POST['name'];
    // Validate the inputs
    if ( empty($name)) {
        $error = "Invalid comment data. Check all fields and try again.";
        include('../../../errors/error.php');
    } else {
        $comment = new Comment($_POST['name']);
        $comment->setTopicID("1");
        $comment->setUserID("1");
        $today = date("Y-m-d");
        $comment->setDatePublished($today);
        commentDB::addComment($comment);

        // Display the comment List page for the current comment
        header("Location: .?");
    }
}
else if ($action == 'show_edit_form') {
    $comments = commentDB::getComments();
    $comment_id = $_POST['comment_id'];
    $comment = commentDB::getComment($comment_id);
    include('comment_edit.php');
}
else if ($action == 'edit_comment') {
    $name = $_POST['name'];
    $edited_comment_id = $_POST['edited_comment_id'];
    // Validate the inputs
    if ( empty($name)) {
        $error = "Invalid comment data. Check all fields and try again.";
        include('../../../errors/error.php');
    } else {
        $comment = new comment($name);
        $comment->setID($edited_comment_id);
        $comment->setTopicID("1");
        $comment->setUserID("1");
        $today = date("Y-m-d");
        $comment->setDatePublished($today);
        commentDB::editComment($comment);
        // Display the comment List page for the current comment
        header("Location: .?");
    }
}
else if ($action == 'show_detail_form') {
   // echo $action;
    $comments = commentDB::getComments();

    $comment_id = $_POST['comment_id'];
    $comment = commentDB::getComment($comment_id);

    include('comment_detail.php');
}
