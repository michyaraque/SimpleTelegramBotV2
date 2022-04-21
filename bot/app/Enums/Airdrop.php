<?php

namespace Enums;


enum Airdrop: int {

    // MENUS 100 - 199
    case JOIN_AIRDROP = 100;
    case MENU_ENTRIES = 101;
    case MENU_TASKS = 102;
    case ACCEPT_TERMS = 105;
    case RANKING_REFERRERS = 106;
    
    // DATABASE 200 - 299
    case ADD_WALLET_TO_DB = 200;
    case ADD_TWITTER_TO_DB = 201;
    
    // CONFIGURATION 500 - 599
    case CONFIGURE_WALLET = 500;
    case CONFIGURE_TWITTER = 501;

    // BANK 600-699
    case BANK = 600;
    
    // MISC +800
    case START = 700;
    case ENTRIES_RELOAD = 800;
    case NULL_CLICK = 900;

    public function translate(): string {
        return match ($this) {
            Airdrop::JOIN_AIRDROP => translate('global.menu.join_airdrop'),
            Airdrop::MENU_ENTRIES => '',
            Airdrop::MENU_TASKS => '',
        };
    }

}