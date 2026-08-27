import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

class IconHelper {
  static IconData getIconData(String iconName) {
    final name = iconName.toLowerCase();

    if (name.contains('bread-slice') || name.contains('fatayer')) {
      return FontAwesomeIcons.breadSlice;
    } else if (name.contains('cookie') || name.contains('croissant')) {
      return FontAwesomeIcons.cookie;
    } else if (name.contains('cake') || name.contains('sweet')) {
      return FontAwesomeIcons.cakeCandles;
    } else if (name.contains('mug') || name.contains('coffee')) {
      return FontAwesomeIcons.mugHot;
    } else if (name.contains('glass') || name.contains('juice')) {
      return FontAwesomeIcons.glassWater;
    } else if (name.contains('fire') || name.contains('offer')) {
      return FontAwesomeIcons.fire;
    } else if (name.contains('truck') || name.contains('delivery')) {
      return FontAwesomeIcons.truckFast;
    } else if (name.contains('leaf') || name.contains('matcha')) {
      return FontAwesomeIcons.leaf;
    } else if (name.contains('receipt') || name.contains('order')) {
      return FontAwesomeIcons.receipt;
    } else if (name.contains('cart')) {
      return FontAwesomeIcons.cartShopping;
    }

    return FontAwesomeIcons.mugHot;
  }
}
