class CategoryModel {
  final int id;
  final String slug;
  final String name;
  final String? nameEn;
  final String icon;
  final String color;
  final String? desc;
  final int sortOrder;
  final int? productsCount;

  CategoryModel({
    required this.id,
    required this.slug,
    required this.name,
    this.nameEn,
    required this.icon,
    required this.color,
    this.desc,
    required this.sortOrder,
    this.productsCount,
  });

  factory CategoryModel.fromJson(Map<String, dynamic> json) {
    return CategoryModel(
      id: json['id'] ?? 0,
      slug: json['slug'] ?? '',
      name: json['name'] ?? json['name_ar'] ?? '',
      nameEn: json['name_en'],
      icon: json['icon'] ?? 'fa-solid fa-mug-hot',
      color: json['color'] ?? '#C8963E',
      desc: json['desc'] ?? json['description'],
      sortOrder: json['sort_order'] ?? 0,
      productsCount: json['products_count'],
    );
  }
}
