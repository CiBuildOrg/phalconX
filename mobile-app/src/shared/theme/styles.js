import React from 'react'
import { Dimensions } from 'react-native'

// Precalculate Device Dimensions for better performance
const x = Dimensions.get('window').width
const y = Dimensions.get('window').height

// Calculating ratio from iPhone breakpoints
const ratioX = x < 375 ? (x < 320 ? 0.75 : 0.875) : 1
const ratioY = y < 568 ? (y < 480 ? 0.75 : 0.875) : 1

// We set our base font size value
const base_unit = 16

// We're simulating EM by changing font size according to Ratio
const unit = base_unit * ratioX

// We add an em() shortcut function
function em(value) {
    return unit * value
}

// Then we set our styles with the help of the em() function
export default Style = {

    // GENERAL
    DEVICE_WIDTH: x,
    DEVICE_HEIGHT: y,
    RATIO_X: ratioX,
    RATIO_Y: ratioY,
    UNIT: em(1),
    PADDING: em(1),
    MARGIN: em(0.75),

    // CARD
    CARD_WIDTH: x - em(1.25) * 2,
    CARD_HEIGHT: (x - em(1.25) * 2) * (3/5),
    CARD_PADDING_X: em(1.875),
    CARD_PADDING_Y: em(1.25),
    AVATAR_WIDTH: x / em(0.8),
    AVATAR_HEIGHT: x / em(0.8),
    THUMBNAIL_WIDTH: x / 5,
    THUMBNAIL_HEIGHT: x / 5,

    // FONT
    FONT_SIZE: em(1.1),
    FONT_SIZE_SMALLER: em(0.75),
    FONT_SIZE_SMALL: em(0.875),
    FONT_SIZE_TITLE: em(1.25),
    FONT_SIZE_LARGE: em(2.25),
    FONT_SIZE_BIG: em(1.5),
    FONT_SIZE_SMALLEST: em(0.8),
    ICON_SIZE: em(1.25),
    ICON_SIZE_SMALL: em(1),
    ICON_SIZE_MEDIUM: em(1.5),
    ICON_SIZE_BIG: em(2),
    ICON_SIZE_LARGE: em(4),

    // COLOR
    PRIMARY_COLOR: '#3F51B5',
    DARK_PRIMARY_COLOR: '#303F9F',
    LIGHT_PRIMARY_COLOR: '#C5CAE9',
    ACCENT_COLOR: '#FF5722',
    PRIMARY_TEXT_COLOR: '#212121',
    SECOND_TEXT_COLOR: '#757575',
    DIVIDER_TEXT_COLOR: '#BDBDBD',
    ICON_COLOR: '#FFFFFF',
    BACKGROUND_COLOR: '#222222',
}
