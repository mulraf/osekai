<?php
mobileManager();
fontawesome();
xhr_requests();
tippy();
tooltip_system(); // to replace old ones
colour_picker();
?>

<script>
    const apps = <?php echo json_encode($apps); ?>;
    const currentlyApp = <?php echo json_encode($app); ?>;
</script>

<img src="https://osu.ppy.sh/assets/images/mod_hidden.cfc32448.png?t=<?php echo time(); ?>" onerror="cantContactOsu()" hidden class="hidden">

<div id="osekai__popup_overlay"></div>
<div class="osekai__blur-overlay" id="blur_overlay" onclick="hide_dropdowns()"></div>
<h1 style="display: none;"><?php echo $apps[$app]['name']; ?></h1>

<div class="osekai__navbar-container">
    <div class="osekai__navbar">
        <?php if (!loggedin()) { ?>
            <!-- <div class="osekai__navbar-warning" style="background-color: #fff2">
        Due to updates to some of our internal systems, all users have been logged out. You'll have to log back in again.
    </div> -->
        <?php } ?>
        <div class="osekai__navbar-warning hidden" id="cantContactOsu">
            Osekai cannot contact osu!'s servers. This may be because osu! is down, or you could be connected to a private server. If you are connected to a private server, please disconnect from it.
        </div>
        <?php if (isRestricted()) { ?>
            <div class="osekai__navbar-restriction">
                <div class="osekai__navbar-restriction-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <div class="osekai__navbar-restriction-text">
                    <h3>Your account on Osekai has been restricted.</h3>
                    <p>To appeal this, please contact us on the <a href="https://discord.com/invite/8qpNTs6">osu! Medal Hunters Discord server</a></p>
                </div>
            </div>
        <?php } ?>

        <div class="osekai__navbar-bottom">
            <div class="osekai__navbar-left">

                <div onclick='hideOtherApps(); navflip(); open_apps_dropdown()' class="osekai__navbar__app-container">

                    <div class="osekai__navbar__app-logo">
                        <img rel="preload" alt="<?php echo $apps[$app]['name']; ?>" src="https://www.osekai.net/global/img/branding/vector/<?php echo $apps[$app]['logo']; ?>.svg">
                    </div>
                    <i class="fas fa-caret-down nav_chevron" id="nav_chevron"></i>
                </div>
            </div>
            <div class="osekai__navbar-right">
                <?php if (loggedin()) { ?>
                    <div class="osekai__navbar-button tooltip-v2" id="notif__bell__button" tooltip-content="<?= GetStringRaw("navbar", "tooltip.notifications"); ?>">
                        <i class="fas fa-bell"></i>
                        <?php if (isExperimental()) { ?>
                            <div class="osekai__notification-counter" selector="NotificationCount">2</div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div onclick='dropdown("osekai__nav-dropdown-hidden", "dropdown__settings", 1)' class="osekai__navbar-button tooltip-v2" tooltip-content="<?= GetStringRaw("navbar", "tooltip.settings"); ?>">
                    <i class="fas fa-cog"></i>
                </div>

                <div id="navbar_searchbut" onclick='openSearch(this)' class="osekai__navbar-button tooltip-v2" tooltip-content="<?= GetStringRaw("navbar", "tooltip.search"); ?>">
                    <i class="fas fa-search"></i>
                </div>

                <img alt="Your profile picture" src="<?php echo getpfp(); ?>" onclick='dropdown("osekai__nav-dropdown-hidden", "dropdown__user", 1)' class="osekai__navbar-pfp <?php if (isExperimental()) {
                                                                                                                                                                                    echo 'osekai__navbar-pfp-experimental';
                                                                                                                                                                                } ?>">
            </div>
        </div>
    </div>
    <div class="osekai__navbar-alerts-container" id="alerts_container">

    </div>
</div>

<div class="graceful__loading-overlay"></div>

<style id="cardstyle">
    .osekai__apps-dropdown-applist-right-card {
        background: linear-gradient(92.75deg, rgba(var(--appColour), 0.5) 0%, rgba(var(--appColour), 0.25) 100%), linear-gradient(92.75deg, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.25) 100%), url(/global/img/.jpg);
        background-size: cover;
        background-position: center;
    }
</style>

<style id="extra_style"></style>

<div class="osekai__apps-dropdown-gradient osekai__apps-dropdown-gradient-hidden" id="osekai__apps-dropdown-gradient" onclick='navflip(); hide_dropdowns()'>

</div>

<?php
$showable_apps = [];


foreach ($apps as $a) {

    $cover = $rooturl . "/global/img/" . $a['cover'] . ".jpg";

    $show = true;
    if ($a['experimental'] == true) {
        if ($_SESSION['options']['experimental'] == false) {
            $show = false;
        } else {
            $show = true;
        }
    }
    if ($a['visible'] == false) {
        $show = false;
    }
    $currentApp = false;
    if ($a['simplename'] == $app) {
        $currentApp = true;
    }
    $url = $rooturl . "/" . $a['simplename'];


    $app_x = [
        "url" => $url,
        "cover" => $cover,
        "show" => $show,
        "app" => $a
    ];
    if ($show == true) {
        $showable_apps[] = $app_x;
    }
}
?>


<div id="dropdown__apps_mobile" class="osekai__apps-dropdown-mobile-hidden osekai__apps-dropdown-mobile mobile">
    <div class="osekai__apps-dropdown-mobile-section" style="--height: 76px;">
        <?php foreach ($showable_apps as $a) { ?>
            <a class="osekai__apps-dropdown-mobile-button osekai__apps-dropdown-mobile-app" href="/<?php echo $a['app']['simplename']; ?>">
                <img alt="Logo for <?php echo $a['app']['simplename']; ?>" src="https://www.osekai.net/global/img/branding/vector/<?php echo $a['app']['logo']; ?>.svg">
                <div class="osekai__apps-dropdown-mobile-app-texts">
                    <h2>osekai <strong><?php echo $a['app']['simplename']; ?></strong></h2>
                    <h3><?php echo $a['app']['slogan']; ?></h3>
                </div>
            </a>
        <?php } ?>
    </div>
    <?php
    if ($_SESSION['options']['experimental'] == 1) {
    ?>
        <div class="osekai__apps-dropdown-mobile-section" style="--height: 59px;">
            <a class="osekai__apps-dropdown-mobile-button">
                <p>other pages</p>
            </a>
        </div>
    <?php } ?>
    <div class="osekai__apps-dropdown-mobile-section" style="--height: 46px;">
        <a class="osekai__apps-dropdown-mobile-button" href="/donate">
            <i class="fas fa-heart"></i>
            <p>support us!</p>
        </a>
        <a class="osekai__apps-dropdown-mobile-button" href="https://twitter.com/osekaiapp">
            <i class="fab fa-twitter"></i>
            <p>check out osekai on twitter!</p>
        </a>
        <a class="osekai__apps-dropdown-mobile-button" href="https://discord.com/invite/8qpNTs6">
            <i class="fab fa-discord"></i>
            <p>join the <strong>osu! Medal Hunters</strong> discord server!</p>
        </a>
        <a class="osekai__apps-dropdown-mobile-button" href="https://discord.gg/uZ9CsQBvqM">
            <i class="fab fa-discord"></i>
            <p>join our development discord!</p>
        </a>
    </div>

    <div class="osekai__apps-dropdown-mobile-section" style="--height: 38px;">
        <a class="osekai__apps-dropdown-mobile-button" href="/legal/privacy">
            <p>privacy policy</p>
        </a>
        <a class="osekai__apps-dropdown-mobile-button" href="/legal/contact">
            <p>contact us</p>
        </a>
    </div>

    <div class="osekai__apps-dropdown-mobile-copyright">
        © Osekai 2019-2022
    </div>
    <div class="extra-space"></div>
</div>

<div id="dropdown__apps" class="osekai__apps-dropdown-hidden osekai__apps-dropdown desktop">
    <div class="osekai__apps-dropdown-image" id="background_image">

    </div>
    <div id="otherapplist" class="osekai__apps-dropdown-applist osekai__apps-dropdown-applist-other osekai__apps-dropdown-hidden">
        <div class="osekai__apps-dropdown-applist-left">

            <div class="osekai__apps-dropdown-applist-left-top">
                <div class="osekai__apps-dropdown-applist-left-bottom" onclick="hideOtherApps()">
                    Back to Apps
                </div>
                <div class="osekai__apps-dropdown-other-content">
                    <a class="osekai__apps-dropdown-other-content-button" href="/misc/translators/">
                        Translators
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="osekai__apps-dropdown-applist" id="outer-app-list">
        <div id="applist" class="osekai__apps-dropdown-applist-left">
            <div class="osekai__apps-dropdown-applist-left-top">
                <?php foreach ($showable_apps as $a) {

                ?>
                    <a onmouseover="setCardDetails('<?php echo $a['app']['simplename']; ?>')" href="/<?php echo $a['app']['simplename']; ?>" class="osekai__apps-dropdown-applist-app<?php if ($currentApp == true) {
                                                                                                                                                                                                            echo " osekai__apps-dropdown-applist-app-active";
                                                                                                                                                                                                        } ?>">

                        <div class="osekai__apps-dropdown-applist-app-icon">
                            <img alt="Logo for <?php echo $a['app']['simplename']; ?>" src="https://www.osekai.net/global/img/branding/vector/<?php echo $a['app']['logo']; ?>.svg">
                        </div>
                        <p>osekai <strong><?php echo $a['app']['simplename']; ?></strong></p>
                    </a>
                <?php

                }
                ?>
            </div>
            <?php
            if ($_SESSION['options']['experimental'] == 1) {
            ?>
                <div class="osekai__apps-dropdown-applist-left-bottom" onclick="showOtherApps()">
                    Other Apps
                </div>
            <?php
            }
            ?>
        </div>
        <div class="osekai__apps-dropdown-applist-right">
            <div id="dropdown_card" class="osekai__apps-dropdown-applist-right-card">
                <div class="osekai__apps-dropdown-applist-right-card-inner">
                    <img id="dropdown_card_icon" alt="Logo" src="https://www.osekai.net/global/img/branding/vector/<?php echo $apps[$app]['logo']; ?>.svg">
                    <div class="osekai__apps-dropdown-applist-right-card-texts">
                        <h3 id="dropdown_card_title">osekai <strong><?php echo $apps[$app]['simplename']; ?></strong></h3>
                        <p id="dropdown_card_content"><?php echo $apps[$app]['slogan']; ?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="osekai__apps-dropdown-bottomleft">
        <!-- support -->
        <a class="osekai__apps-dropdown-bottomleft-extra" href="<?php echo $rooturl; ?>/donate">
            <p><?php echo GetStringRaw("navbar", "apps.support"); ?></p>
            <div class="osekai__apps-dropdown-bottomleft-extra-icon">
                <i class="fas fa-heart"></i>
            </div>
        </a>
        <a class="osekai__apps-dropdown-bottomleft-extra" href="https://twitter.com/osekaiapp">
            <p><?php echo GetStringRaw("navbar", "apps.twitter"); ?></p>
            <div class="osekai__apps-dropdown-bottomleft-extra-icon">
                <i class="fab fa-twitter"></i>
            </div>
        </a>
        <a rel="me" href="https://mastodon.world/@osekai" class="osekai__apps-dropdown-bottomleft-extra">
            <p>check out osekai on mastodon! (twitter mirror)</p>
            <div class="osekai__apps-dropdown-bottomleft-extra-icon">
                <i class="fab fa-mastodon"></i>
            </div>
        </a>
        <a class="osekai__apps-dropdown-bottomleft-extra" href="https://discord.com/invite/8qpNTs6">
            <p><?php echo GetStringRaw("navbar", "apps.discord"); ?></p>
            <div class="osekai__apps-dropdown-bottomleft-extra-icon">
                <i class="fab fa-discord"></i>
            </div>
        </a>
        <a class="osekai__apps-dropdown-bottomleft-extra" href="https://discord.gg/uZ9CsQBvqM">
            <p><?php echo GetStringRaw("navbar", "apps.developmentDiscord"); ?></p>
            <div class="osekai__apps-dropdown-bottomleft-extra-icon">
                <i class="fab fa-discord"></i>
            </div>
        </a>
    </div>

    <div class="osekai__apps-dropdown-bottomright">
        <div class="links">
            <a href="https://github.com/Osekai">github</a>
            <a href="https://github.com/Osekai/api-docs/wiki">API documentation</a>
            <a href="<?php echo $rooturl; ?>/legal/contact"><?php echo GetStringRaw("navbar", "apps.contact"); ?></a>
            <a href="<?php echo $rooturl; ?>/legal/privacy"><?php echo GetStringRaw("navbar", "apps.privacy"); ?></a>
        </div>
        <div class="osekai__apps-dropdown-bottomright-copyright">
            © Osekai 2019-<?php echo date("Y"); ?>
        </div>
    </div>
</div>


<?php if (loggedin()) { ?>
    <style>
        .osekai__userdropdown-bg {
            background-image: linear-gradient(to left, rgba(0, 0, 0, 0.0), rgba(0, 0, 0, 0.5)), url(<?php echo getcover(); ?>);
        }

        .osekai__userdropdown_v2-bg {
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.51) 23.05%, rgba(0, 0, 0, 0) 100%), center/100% url(<?php echo getcover(); ?>);
        }

        .osekai__nav-dropdown-v2-mainpanel {
            background: linear-gradient(263.14deg, rgba(var(--accentdark), 0.568) -1.04%, rgba(var(--accentdark), 0.8) 100%), linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, rgba(0, 0, 0, 0.3) 100%), url(<?php echo getcover(); ?>), linear-gradient(0deg, rgba(var(--accentdark), 0.5), rgba(var(--accentdark), 0.5)), rgba(0, 0, 0, 0.5);
            background-blend-mode: normal, luminosity, normal, normal, normal;
            background-size: cover, cover, cover, cover, cover;
            background-position: center, center, center, center, center;
            background-repeat: no-repeat, no-repeat, no-repeat, no-repeat, no-repeat;
        }
    </style>
<?php } ?>



<div id="dropdown__user" class="osekai__nav-dropdown-v2 osekai__nav-dropdown-hidden">
    <?php if (loggedin()) { ?>
        <div class="osekai__nav-dropdown-v2-mainpanel">
            <a href="/profiles?user=<?php echo $_SESSION['osu']['id']; ?>"><img class="osekai__nav-dropdown-v2-mainpanel-avatar" src="<?php echo getpfp(); ?>"></a>
            <div class="osekai__nav-dropdown-v2-mainpanel-texts osekai__nav-dropdown-v2-mainpanel-texts-loading" id="userdropdown_texts-loading">
                <svg viewBox="0 0 50 50" class="spinner">
                    <circle class="ring" cx="25" cy="25" r="22.5"></circle>
                    <circle class="line" cx="25" cy="25" r="22.5"></circle>
                </svg>
            </div>
            <div class="osekai__nav-dropdown-v2-mainpanel-texts hidden" id="userdropdown_texts">
                <div class="osekai__nav-dropdown-v2-mainpanel-texts-top">
                    <p class="osekai__nav-dropdown-v2-mainpanel-texts-left"><?php echo $_SESSION['osu']['username']; ?></p>
                    <p class="osekai__nav-dropdown-v2-mainpanel-texts-right" id="userdropdown_club">0% Club</p>
                </div>
                <div class="osekai__progress-bar">
                    <div class="osekai__progessbar-inner" id="userdropdown__bar" style="width: 82.32%;"></div>
                </div>
                <div class="osekai__nav-dropdown-v2-mainpanel-texts-bottom">
                    <p class="osekai__nav-dropdown-v2-mainpanel-texts-left" id="userdropdown_pp">0pp</p>
                    <p class="osekai__nav-dropdown-v2-mainpanel-texts-right" id="userdropdown_medals">0 medals</p>
                </div>
            </div>
        </div>
        <div class="osekai__nav-dropdown-v2-lowerpanel">
            <?php if ($_SESSION['options']['experimental'] == 1) { ?>
                <!-- <div class="oseaki__nav-dropdown-user-v2-lowerpanel-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p><?php echo GetStringRaw("navbar", "profile.experimentalMode"); ?></p>
                </div> -->
                <div class="osekai__generic-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p><?php echo GetStringRaw("navbar", "profile.experimentalMode"); ?></p>
                </div>
                <a class="osekai__nav-dropdown-v2-lowerpanel-button" style="--col: 255, 100, 0" onclick="ExperimentalOff()">
                    <div class="osekai__nav-dropdown-v2-lowerpanel-button-bar"></div>
                    <p>
                        Turn Experimental Mode Off
                    </p>
                </a>
            <?php } ?>
            <a class="osekai__nav-dropdown-v2-lowerpanel-button" style="--col: 104, 143, 255" href="/profiles?user=<?php echo $_SESSION['osu']['id']; ?>">
                <div class="osekai__nav-dropdown-v2-lowerpanel-button-bar"></div>
                <p>
                    <?php echo GetStringRaw("navbar", "profile.viewOnOsekaiProfiles"); ?>
                </p>
            </a>
            <a class="osekai__nav-dropdown-v2-lowerpanel-button" style="--col: 255, 102, 170" href="https://osu.ppy.sh/users/<?php echo $_SESSION['osu']['id']; ?>">
                <div class="osekai__nav-dropdown-v2-lowerpanel-button-bar"></div>
                <p>
                    <?php echo GetStringRaw("navbar", "profile.viewOnOsu"); ?>
                </p>
            </a>
            <a class="osekai__nav-dropdown-v2-lowerpanel-button" style="--col: 255, 0, 0" href="https://www.osekai.net/global/php/logout.php">
                <div class="osekai__nav-dropdown-v2-lowerpanel-button-bar"></div>
                <p><?php echo GetStringRaw("navbar", "profile.logOut"); ?></p>
            </a>
        </div>
    <?php } else { ?>
        <div class="osekai__nav-dropdown-v2-lowerpanel">
            <a class="osekai__nav-dropdown-v2-lowerpanel-button" style="--col: 255, 102, 170" href="<?php echo $loginurl; ?>" onclick="openLoader('Logging you in...'); hide_dropdowns();">
                <div class="osekai__nav-dropdown-v2-lowerpanel-button-bar"></div>
                <p><?php echo GetStringRaw("navbar", "profile.logIn"); ?></p>
            </a>

        </div>
    <?php } ?>
</div>

<div id="dropdown__settings" class="osekai__nav-dropdown-v2 osekai__nav-dropdown-v2-generic osekai__nav-dropdown-v2-settings osekai__nav-dropdown-hidden">
    <div class="osekai__nav-dropdown-v2-mainpanel">
        <img src="/global/img/branding/vector/osekai_light.svg" class="osekai__nav-dropdown-v2-mainpanel-logo">
        <div class="osekai__nav-dropdown-v2-mainpanel-texts">
            <h2><?php echo GetStringRaw("navbar", "settings.title"); ?></h2>
            <p><?php echo GetStringRaw("navbar", "settings.subtitle"); ?></p>
        </div>
    </div>
    <div class="osekai__nav-dropdown-v2-lowerpanel">

        <h1 class="osekai__dropdown-button-head"><?php echo GetStringRaw("navbar", "settings.global.title"); ?></h1>
        <h2 class="osekai__dropdown-button-subhead"><?php echo GetStringRaw("navbar", "settings.global.theme"); ?></h2>
        <div class="osekai__nav-dropdown-v2-dropdowncontainer">
            <div class="osekai__dropdown-button-inner osekai__dropdown-opener" onclick="OpenSettingsDropdown('dropdown__themes');">
                <p id="dropdown__themes-text">system theme</p>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="osekai__dropdown osekai__dropdown-hidden" id="dropdown__themes">
                <div class="osekai__dropdown-item osekai__dropdown-item-active">Username</div>
                <div class="osekai__dropdown-item">User ID</div>
                <div class="osekai__dropdown-item">Country</div>
                <div class="osekai__dropdown-item">Rarest Medal</div>
            </div>
        </div>
        <div id="customThemePicker" class="osekai__nav-dropdown-v2-split-colour-picker">
            <div class="osekai__nav-dropdown-v2-split-colour-picker-half">
                <div class="osekai__colour-picker" id="custom_colpicker_accent-dark">
                    <input type="text"></input>
                </div>
                </p>Accent Dark</p>
            </div>
            <div class="osekai__nav-dropdown-v2-split-colour-picker-half">
                <div class="osekai__colour-picker" id="custom_colpicker_accent">
                    <input type="text"></input>
                </div>
                <p>Accent</p>
            </div>
        </div>
        <?php if (1 == 1) { ?>
            <h2 class="osekai__dropdown-button-subhead"><?php echo GetStringRaw("navbar", "settings.global.language"); ?></h2>
            <div class="osekai__nav-dropdown-v2-dropdowncontainer">
                <div class="osekai__dropdown-button-inner osekai__dropdown-opener" onclick="OpenSettingsDropdown('dropdown__languages');">
                    <p id="dropdown__languages-text"><?php echo $currentLocale['name']; ?></p>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="osekai__dropdown osekai__dropdown-hidden" id="dropdown__languages">
                    <?php
                    //print_r($locales);
                    foreach ($locales as $language) {
                        if ($language['experimental'] == true && $_SESSION['options']['experimental'] == 0) {
                            continue;
                        }
                    ?>
                        <div class="osekai__dropdown-item" onclick="setLanguage('<?php echo $language['code']; ?>');">
                            <img src="<?php echo $language["flag"]; ?>" class="osekai__dropdown-item-flag">

                            <?php

                            if (isset($language['experimental']) && $language['experimental'] == 1) {
                                echo "<span class='osekai__dropdown-item-exp'>EXP</span>";
                            } else if (isset($language['wip']) && $language['wip'] == 1) {
                                echo "<span class='osekai__dropdown-item-wip'>WIP</span>";
                            }
                            echo "<p>" . $language["name"] . "</p>"; ?>

                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <h1 class="osekai__dropdown-button-head"><?php echo GetStringRaw("navbar", "settings.profiles.title"); ?></h1>
        <div class="osekai__flex_row osekai__fr_centered osekai_100">
            <p class="osekai__checkbox-label"><?php echo GetStringRaw("navbar", "settings.profiles.showMedalsFromAllModes"); ?></p>
            <input class="osekai__checkbox" id="settings_profiles__showmedalsfromallmodes" type="checkbox" value="value1" onchange="saveSettings();">
            <label for="settings_profiles__showmedalsfromallmodes"></label>
        </div>
        <h1 class="osekai__dropdown-button-head">Medals</h1>
        <div class="osekai__flex_row osekai__fr_centered osekai_100">
            <p class="osekai__checkbox-label">Completely hide medals when unobtained filter enabled</p>
            <input class="osekai__checkbox" id="settings_medals__hidemedalswhenunobtainedfilteron" type="checkbox" value="value1" onchange="saveSettings();">
            <label for="settings_medals__hidemedalswhenunobtainedfilteron"></label>
        </div>
    </div>
</div>

<?php if ($_SESSION['options']['experimental'] == 1) { ?>
    <div id="dropdown__notifs" class="osekai__nav-dropdown-v2 osekai__nav-dropdown-v2-generic osekai__nav-dropdown-v2-notifications osekai__nav-dropdown-hidden">
        <div class="osekai__nav-dropdown-v2-mainpanel">
            <i class="fas fa-bell"></i>
            <div class="osekai__nav-dropdown-v2-mainpanel-texts">
                <h2><?php echo GetStringRaw("navbar", "notifications.title"); ?></h2>
                <p>catch up with what's goin' on</p>
            </div>
        </div>
        <div class="osekai__nav-dropdown-v2-lowerpanel">
            <div class="osekai__nav-dropdown-v2-notifications-header">
                <div class="osekai__nav-dropdown-v2-notifications-header-left">
                    <p><strong selector="NotificationCount">5</strong> notifications</p>
                </div>
                <div class="osekai__nav-dropdown-v2-notifications-header-right">
                    <p>clear all</p> <i class="far fa-times-circle"></i>
                </div>
            </div>
            <div id="notification__list__v2" class="osekai__nav-dropdown-v2-notifications-list">
                <div class="osekai__nav-dropdown-v2-notification">
                    <div class="osekai__nav-dropdown-v2-notification-upper">
                        <img src="/global/img/branding/vector/osekai_light.svg">
                        <p>Test notification text</p>
                    </div>
                </div>
                <div class="osekai__nav-dropdown-v2-notification">
                    <a class="osekai__nav-dropdown-v2-notification-upper osekai__nav-dropdown-v2-notification-upper-clickable" href="test">
                        <img src="/global/img/branding/vector/white/profiles.svg">
                        <p>Test notification text with description</p>
                    </a>
                    <div class="osekai__nav-dropdown-v2-notification-lower">
                        <p>what a cool description we have here!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="dropdown__notifs" class="osekai__nav-dropdown-hidden osekai__nav-dropdown osekai__nav-dropdown-notifs">
        <div class="osekai__notifications-header">
            <?php echo GetStringRaw("navbar", "notifications.title"); ?>
            <div id="notification__counter" class="osekai__notifications-header-right">
            </div>
        </div>
        <div id="notification__list" class="osekai__notifications-list">
        </div>
    </div>
<?php } ?>
<?php
if ($coltype == "3") {
?>
    <div class="osekai__ct3-sidebar">
        <div id="3col_arrow" class="osekai__ct3-arrow_area ct3open" onclick="switch3col();">
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>
<?php
}
?>

<div id="loading_overlay">
</div>

<div id="other_overlays">
</div>

<div id="css_cont"></div>

<script type="text/javascript" src="<?php echo $rooturl; ?>/global/js/variables.js?v=<?php echo OSEKAI_VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo $rooturl; ?>/global/js/main.js?v=<?php echo OSEKAI_VERSION; ?>"></script>

<script>
    if (<?php echo $_SESSION['options']['experimental'] ?? 0; ?> == 1) toggleExperimental();
</script>

<meta name="viewport" content="width=device-width, initial-scale=1">

<?php

include("search_overlay.php");

?>


<script src="<?php echo $rooturl; ?>/global/js/navbar.js"></script>

<?php
if ($christmas == true) { ?>

    <style>
        /* customizable snowflake styling */
        .snowflake {
            color: #fff;
            font-size: 1em;
            font-family: Arial, sans-serif;
            text-shadow: 0 0 5px #000;
            filter: drop-shadow(0 0 5px #fff4);
            opacity: 0.5;
            pointer-events: none;
        }

        @-webkit-keyframes snowflakes-fall {
            0% {
                top: -10%
            }

            100% {
                top: 100%
            }
        }

        @-webkit-keyframes snowflakes-shake {

            0%,
            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0)
            }

            50% {
                -webkit-transform: translateX(80px);
                transform: translateX(80px)
            }
        }

        @keyframes snowflakes-fall {
            0% {
                top: -10%
            }

            100% {
                top: 100%
            }
        }

        @keyframes snowflakes-shake {

            0%,
            100% {
                transform: translateX(0)
            }

            50% {
                transform: translateX(80px)
            }
        }

        .snowflake {
            position: fixed;
            top: -10%;
            z-index: 9999;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            cursor: default;
            -webkit-animation-name: snowflakes-fall, snowflakes-shake;
            -webkit-animation-duration: 10s, 3s;
            -webkit-animation-timing-function: linear, ease-in-out;
            -webkit-animation-iteration-count: infinite, infinite;
            -webkit-animation-play-state: running, running;
            animation-name: snowflakes-fall, snowflakes-shake;
            animation-duration: 10s, 3s;
            animation-timing-function: linear, ease-in-out;
            animation-iteration-count: infinite, infinite;
            animation-play-state: running, running
        }

        .snowflake:nth-of-type(0) {
            left: 1%;
            -webkit-animation-delay: 0s, 0s;
            animation-delay: 0s, 0s
        }

        .snowflake:nth-of-type(1) {
            left: 10%;
            -webkit-animation-delay: 1s, 1s;
            animation-delay: 1s, 1s
        }

        .snowflake:nth-of-type(2) {
            left: 20%;
            -webkit-animation-delay: 6s, .5s;
            animation-delay: 6s, .5s
        }

        .snowflake:nth-of-type(3) {
            left: 30%;
            -webkit-animation-delay: 4s, 2s;
            animation-delay: 4s, 2s
        }

        .snowflake:nth-of-type(4) {
            left: 40%;
            -webkit-animation-delay: 2s, 2s;
            animation-delay: 2s, 2s
        }

        .snowflake:nth-of-type(5) {
            left: 50%;
            -webkit-animation-delay: 8s, 3s;
            animation-delay: 8s, 3s
        }

        .snowflake:nth-of-type(6) {
            left: 60%;
            -webkit-animation-delay: 6s, 2s;
            animation-delay: 6s, 2s
        }

        .snowflake:nth-of-type(7) {
            left: 70%;
            -webkit-animation-delay: 2.5s, 1s;
            animation-delay: 2.5s, 1s
        }

        .snowflake:nth-of-type(8) {
            left: 80%;
            -webkit-animation-delay: 1s, 0s;
            animation-delay: 1s, 0s
        }

        .snowflake:nth-of-type(9) {
            left: 90%;
            -webkit-animation-delay: 3s, 1.5s;
            animation-delay: 3s, 1.5s
        }

        .snowflake:nth-of-type(10) {
            left: 25%;
            -webkit-animation-delay: 2s, 0s;
            animation-delay: 2s, 0s
        }

        .snowflake:nth-of-type(11) {
            left: 65%;
            -webkit-animation-delay: 4s, 2.5s;
            animation-delay: 4s, 2.5s
        }
    </style>
    <div class="snowflakes" aria-hidden="true">
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
        <div class="snowflake">
            <i class="fas fa-snowflake"></i>
        </div>
    </div>

<?php } ?>