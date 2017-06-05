<?php

/*********************************************************************
 *
 * Pure PHP radius class challenge/response demo
 *
 * Change Log
 *
 *   2008-07-07 1.2   SysCo/al Initial release
 *                             Added Jon Bright (tick Trading Software AG) contribution
 *                              - challenge/response support demo for the RSA SecurID New-PIN mode
 *
 *********************************************************************/
 
require_once('radius.class.php');

?>
<html>
    <head>
        <title>
            Pure PHP radius class challenge/response demo
        </title>
    </head>
    <body>
        <?php
        if ((isset($_POST['user'])) && ('' != trim($_POST['user'])))
        {
            $radius = new Radius('127.0.0.1', 'secret');

            // Enable Debug Mode for the demonstration
            $radius->SetDebugMode(TRUE);

            if (isset($_POST['state']) && strlen($_POST['state'])>0 && strlen($_POST['state'])<254)
            {
                $state = $_POST['state'];
                $state = pack('H*', $state);
            }
            else
            {
                $state = NULL;
            }

            if ($radius->AccessRequest($_POST['user'], $_POST['pass'], 0, $state))
            {
                echo "<strong>Authentication accepted.</strong>";
            }
            else
            {
                if ($radius->GetReceivedPacket()==11) // Access-Challenge, sent by RSA RADIUS when PIN needs changing
                {
                    if ($radius->GetAttribute(18)!==NULL)
                    {
                        // There's a Reply-Message, show it to the user.
                        // The standard from RSA for this is "Enter a new PIN having from 4 to 8 digits:\000"
                        // Since that \000 looks pretty silly in HTML, get rid of it
                        $msg = $radius->GetAttribute(18);
                        $msg = str_replace("\000","",$msg);
                    }
                    else
                    {
                        $msg = "Challenge received from server";
                    }
                    echo "<strong>".$msg."</strong>";
                    ?>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    User: <input name="user" type="text" value="<?php echo $_POST["user"]; ?>" />
                    <br />

                    <?php
                    if ($radius->GetAttribute(76)===0) // The RADIUS RFC excludes the possibility of sending this attr, but RSA send it.  0 means "No echo".
                    {
                        ?>
                        Pass: <input name="pass" type="text" value="" /> (text type for educational purpose only) <!-- type="text" for educational purpose only ! -->
                        <?php
                    }
                    else
                    {
                        ?>
                        Pass: <input name="pass" type="text" value="" /> <!-- this should *actually* be text - the server didn't tell us to use "no-echo" -->
                        <?php
                    }
                    if ($radius->GetAttribute(24)!==NULL)
                    {
                        ?>
                        <input name="state" type="hidden" value="<?php echo bin2hex($radius->GetAttribute(24)); ?>" />
                        <?php
                    }
                    ?>
                    <br />

                    <input name="submit" type="submit" value="Check authentication" />
                    </form>
                    <?php
                }
                else
                {
                    echo "<strong>Authentication rejected.</strong>";
                }
            }
            echo "<br />";

            echo "<br /><strong>GetReadableReceivedAttributes</strong><br />";
            echo $radius->GetReadableReceivedAttributes();

            echo "<br />";
            echo "<a href=\"".$_SERVER['PHP_SELF']."\">Reload authentication form</a>";
        }
        else
        {
            ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                User: <input name="user" type="text" value="user" />
                <br />

                Pass: <input name="pass" type="text" value="" /> (text type for educational purpose only) <!-- type="text" for educational purpose only ! -->
                <br />
                
                <input name="submit" type="submit" value="Check authentication" />
            </form>
            <?php
        }
        ?>
    </body>
<html>
