<?php

require('../include/mellivora.inc.php');

enforce_authentication(CONFIG_UC_MODERATOR);

validate_id($_GET['id']);

$stmt = $db->prepare('SELECT * FROM categories WHERE id = :id');
$stmt->execute(array(':id' => $_GET['id']));
$category = $stmt->fetch(PDO::FETCH_ASSOC);

head('Site management');
menu_management();

section_subhead('Edit category: ' . $category['title']);
form_start('edit_category');
form_input_text('Title', $category['title']);
form_textarea('Description', $category['description']);
form_input_text('Available from', date_time($category['available_from']));
form_input_text('Available until', date_time($category['available_until']));
form_hidden('action', 'edit');
form_hidden('id', $_GET['id']);
form_button_submit('Save changes');
form_end();

section_subhead('Delete category: ' . $category['title']);
form_start();
form_input_checkbox('Delete confirmation');
form_hidden('action', 'delete');
form_hidden('id', $_GET['id']);
message_inline_warning('Warning! This will delete all challenges under this category, as well as all submissions, files, and hints related those challenges!');
form_button_submit('Delete category', 'danger');
form_end();

foot();