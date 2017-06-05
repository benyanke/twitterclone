<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta content="width=device-width,initial-scale=1" name="viewport">

	

	<?php if(isset($this->viewdata['page-description'])) { ?>
		<title><?php echo $this->viewdata['page-title']; ?></title>
	<?php } else { ?>
		<title>TwitterClone</title>
	<?php } ?>

	<?php if(isset($this->viewdata['page-author'])) { ?>
		<meta content="<?php echo $this->viewdata['page-author']; ?>" name="author">
	<?php } ?>
	

	<?php if(isset($this->viewdata['page-description'])) { ?>
		<meta content="<?php echo $this->viewdata['page-description']; ?>" name="description">
	<?php } ?>
	
	<?php if(isset($this->viewdata['page-keywords'])) { ?>
		<meta content="<?php echo $this->viewdata['page-keywords']; ?>" name="keywords">
	<?php } ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link href="<?php echo $this->viewdata['root-url']; ?>/assets/style.css" rel="stylesheet" type="text/css">

</head>
<body>
	<div class="wrapper">

