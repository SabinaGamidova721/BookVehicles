<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
	<style>
     body {
        background-image: url('<?php echo $profpic;?>');
        background-size: cover; 
        background-repeat: no-repeat;
     }

     .container {
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh; 
     }

     .content {
         background-color: #ffffff;
         padding: 20px; 
         border-radius: 10px; 
         box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
     }

    .pages {
        border: 2px solid #f5b813;
        height: 30px;
        width: 30px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        text-decoration: none;
        color: black; 
    }

    .pages.active {
        border: 2px solid red;
        height: 30px;
        width: 30px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        text-decoration: none;
        color: black; 
    }

     .pages.arrow {
        border: 2px solid white;
        height: 30px;
        width: 30px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        text-decoration: none;
        font-weight: bold;
    }
   </style>
</head>
<body>