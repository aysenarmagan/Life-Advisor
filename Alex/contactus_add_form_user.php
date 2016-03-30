<?php require_once '../content_top.php'; ?>

    <title>Contact Us</title>

<?php require_once('database.php') ?>

    <link rel="stylesheet" href="scripts/contactus.css">

<?php  $user_id = 3 ?>

<?php
//---------- Query (shows only user questions) ---------->

$query = 'SELECT * FROM contactus WHERE userID = :user_id ORDER BY questionID DESC';
$statement = $db->prepare($query);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
$row = $statement->fetchAll();
$statement->closeCursor();
?>

    <h3>Do you have a question? Ask it!</h3>

    <form action="contactus_add_user.php" method="post">

        <!---------- User ID ---------->

        <input type="hidden" name="user_id" value="<?php echo $user_id ?>"/>


        <!---------- Question ---------->

        <div class="contactus_form_field">
            <div class="contactus_form_lable">
                <label>Question: <span class="contactus_form_star">*</span></label>
            </div>
            <div class="contactus_form_input">
                <textarea cols="40" rows="5" name="question"></textarea>
            </div>
        </div>

        <!---------- Category of question ---------->

        <div class="contactus_form_field">
            <div class="contactus_form_lable">
                <label>Category of question: <span class="contactus_form_star">*</span></label>
            </div>
            <div class="contactus_form_input">
                <select name="category">
                    <option value="General">General</option>
                    <option value="Recipes">Recipes</option>
                    <option value="House">House</option>
                    <option value="Health">Health</option>
                    <option value="Health">Finances</option>
                    <option value="Health">People</option>
                </select>
            </div>
        </div>

        <!---------- Question Date ---------->

        <input type="hidden" name="question_date" value="<?php echo strftime("%Y-%m-%d") ?>"/>

        <!---------- Add Button ---------->

        <div class="contactus_form_button">
            <label>&nbsp;</label>
            <input type="submit" value="Ask the question" />
        </div>

    </form>

    <!---------- Questions and Answers ---------->

<?php
foreach ($row as $r) {
    ?>
    <div class="contactus_q_a">
        <div class="contactus_category">
            <p><b>Category: </b><?php echo $r['category']; ?></p>
            <p>| <?php echo $r['questionDate']; ?> |</p>
        </div>
        <div class="contactus_question">
            <p><b>Question:</b></p>
            <p><?php echo $r['question']; ?></p>
            <p><b><?php echo $r['userID']; ?></b></p>
        </div>
        <div class="contactus_answer">
            <p><b>Answer:</b></p>
            <p><?php echo $r['answer']; ?></p>
            <p><?php echo $r['answerDate']; ?></p>
        </div>
        <div class="contactus_admin_buttons">
            <form class="contactus_admin_button_delete" action="contactus_delete_user.php" method="post">
                <input type="hidden" name="question_id" value="<?php echo $r['questionID']; ?>" />
                <input type="submit" value="Delete" />
            </form>
        </div>
    </div>

    <?php
}
?>

<?php require_once '../content_bottom.php'; ?>