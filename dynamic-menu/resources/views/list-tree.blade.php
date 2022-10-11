<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Tree</title>

    @vite(['resources/css/listree.min.css', 'resources/js/listree.umd.min.js'])

    <style>
        .context-menu {
            position: absolute;
            text-align: center;
            background: lightgray;
            border: 1px solid black;
        }

        .context-menu ul {
            padding: 0px;
            margin: 0px;
            min-width: 150px;
            list-style: none;
        }

        .context-menu ul li {
            padding-bottom: 7px;
            padding-top: 7px;
            border: 1px solid black;
        }

        .context-menu ul li a {
            text-decoration: none;
            color: black;
        }

        .context-menu ul li:hover {
            background: darkgray;
        }
    </style>
</head>

<body onload="listree()">
    <ul class="listree">
        <li>
            <div class="listree-submenu-heading">Item 1</div>
            <ul class="listree-submenu-items">
                <li>
                    <div class="listree-submenu-heading">Item 1-1</div>
                    <ul class="listree-submenu-items">
                        <li>
                            <div class="listree-submenu-heading">Item 1-1-1</div>
                            <ul class="listree-submenu-items">
                                <li>
                                    <div class="listree-submenu-heading">Item 1-1-1-1</div>
                                    <ul class="listree-submenu-items">
                                        <li>
                                            <a href="">Item 1-1-1-1-1</a>
                                        </li>
                                        <li>
                                            <a href="">Item 1-1-1-1-2</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <div class="listree-submenu-heading">Item 2</div>
            <ul class="listree-submenu-items">
                <li>
                    <div class="listree-submenu-heading">Item 2-1</div>
                    <ul class="listree-submenu-items">
                        <li>
                            <div class="listree-submenu-heading">Item 2-1-1</div>
                            <ul class="listree-submenu-items">
                                <li>
                                    <div class="listree-submenu-heading">Item 2-1-1-1</div>
                                    <ul class="listree-submenu-items">
                                        <li>
                                            <a href="">Item 2-1-1-1-1</a>
                                        </li>
                                        <li>
                                            <a href="">Item 2-1-1-1-2</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>

    <div id="contextMenu" class="context-menu" style="display:none">
        <ul>
            <li><a href="#">Link-1</a></li>
            <li><a href="#">Link-2</a></li>
            <li><a href="#">Link-3</a></li>
        </ul>
    </div>

    <script>
        document.onclick = hideMenu;
        document.oncontextmenu = rightClick;

        function hideMenu() {
            document.getElementById(
                "contextMenu").style.display = "none"
        }

        function rightClick(e) {
            e.preventDefault();

            if (document.getElementById("contextMenu").style.display == "block")
                hideMenu();
            else {
                var menu = document.getElementById("contextMenu")

                menu.style.display = 'block';
                menu.style.left = e.pageX + "px";
                menu.style.top = e.pageY + "px";
            }
        }
    </script>

</body>

</html>
