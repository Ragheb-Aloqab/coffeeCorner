class SettingModel {
  final double minOrderAmount;
  final String deliveryTime;
  final String storeStatus;

  SettingModel({
    required this.minOrderAmount,
    required this.deliveryTime,
    required this.storeStatus,
  });

  factory SettingModel.fromJson(Map<String, dynamic> json) {
    return SettingModel(
      minOrderAmount: (json['min_order_amount'] as num?)?.toDouble() ?? 30.0,
      deliveryTime: json['delivery_time'] ?? '30 - 45 دقيقة',
      storeStatus: json['store_status'] ?? 'open',
    );
  }
}
