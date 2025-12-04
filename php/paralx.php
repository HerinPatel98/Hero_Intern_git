<!DOCTYPE html>
<html>

<head>
    <title>Paralx BG | Modern BgG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body,
        html {
            height: 100%;
        }

        div {
            position: relative;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            text-align: center;
        }

        .parallax {
            /* The image used */
            background-image: url('../Images/excel.png');
            /* Full height */
            height: 100%;
            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .header-board {
            padding: 10%;
            background: hsl(280, 94%, 90%);
            font-size: 26px;
        }
        .board {
            padding: 5%;
            height: 100px;
            background-color: hsl(280, 94%, 64%);
            font-size: 26px;
        }
    </style>
</head>

<body>
    <div class="parallax" style="background-image: url('../Images/car1.jpg')"></div>
    <div class="header-board">About Us</div>

    
    <div class="parallax" style="background-image: url('../Images/car2.jpg');"></div>
    <div class="board">
        Scroll Up and Down this page to see the parallax scrolling effect.
        This div is just here to enable scrolling.
        Tip: Try to remove the background-attachment property to remove the scrolling effect.
    </div>
    
    <div class="parallax" style="background-image: url('../Images/car3.jpg')"></div>
    <div class="header-board">About Us</div>
    <div class="parallax" style="background-image: url('../Images/car4.jpg')"></div>
    <div class="board">
        Scroll Up and Down this page to see the parallax scrolling effect.
        This div is just here to enable scrolling.
        Tip: Try to remove the background-attachment property to remove the scrolling effect.
    </div>

    <div class="parallax" style="background-image: url('../Images/excel.png')"></div>

</body>

</html>