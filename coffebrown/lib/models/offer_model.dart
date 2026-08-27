import 'product_model.dart';

class OfferModel {
  final int id;
  final int productId;
  final String label;
  final double discount;
  final String? desc;
  final ProductModel? product;

  OfferModel({
    required this.id,
    required this.productId,
    required this.label,
    required this.discount,
    this.desc,
    this.product,
  });

  factory OfferModel.fromJson(Map<String, dynamic> json) {
    return OfferModel(
      id: json['id'] ?? 0,
      productId: json['productId'] ?? json['product_id'] ?? 0,
      label: json['label'] ?? json['label_ar'] ?? 'عرض اليوم',
      discount: (json['discount'] as num?)?.toDouble() ?? 0.0,
      desc: json['desc'] ?? json['description'],
      product: json['product'] != null ? ProductModel.fromJson(json['product']) : null,
    );
  }
}
