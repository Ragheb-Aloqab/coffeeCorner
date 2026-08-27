import 'category_model.dart';

class ProductModel {
  final int id;
  final int categoryId;
  final CategoryModel? category;
  final String name;
  final String? desc;
  final double price;
  final String? image;
  final String icon;
  final double rating;
  final int reviews;
  final bool hasMatchaAddon;
  final bool isActive;

  ProductModel({
    required this.id,
    required this.categoryId,
    this.category,
    required this.name,
    this.desc,
    required this.price,
    this.image,
    required this.icon,
    required this.rating,
    required this.reviews,
    required this.hasMatchaAddon,
    required this.isActive,
  });

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] ?? 0,
      categoryId: json['category_id'] ?? 0,
      category: json['category'] != null ? CategoryModel.fromJson(json['category']) : null,
      name: json['name'] ?? json['name_ar'] ?? '',
      desc: json['desc'] ?? json['description'],
      price: (json['price'] as num?)?.toDouble() ?? 0.0,
      image: json['image'],
      icon: json['icon'] ?? 'fa-solid fa-mug-hot',
      rating: (json['rating'] as num?)?.toDouble() ?? 5.0,
      reviews: json['reviews'] ?? json['reviews_count'] ?? 0,
      hasMatchaAddon: json['hasMatchaAddon'] ?? json['has_matcha_addon'] ?? false,
      isActive: json['is_active'] ?? true,
    );
  }
}
