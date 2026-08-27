import 'package:flutter/material.dart';
import '../core/constants/api_constants.dart';
import '../core/network/api_client.dart';
import '../models/category_model.dart';
import '../models/offer_model.dart';
import '../models/product_model.dart';
import '../models/setting_model.dart';

class CatalogProvider extends ChangeNotifier {
  List<CategoryModel> _categories = [];
  List<ProductModel> _products = [];
  List<OfferModel> _offers = [];
  SettingModel? _settings;

  bool _isLoading = false;
  String? _errorMessage;

  String _selectedCategoryId = 'all';
  String _searchQuery = '';

  List<CategoryModel> get categories => _categories;
  List<OfferModel> get offers => _offers;
  SettingModel? get settings => _settings;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  String get selectedCategoryId => _selectedCategoryId;
  String get searchQuery => _searchQuery;

  List<ProductModel> get filteredProducts {
    return _products.where((p) {
      final bool matchesCategory = _selectedCategoryId == 'all' ||
          p.categoryId.toString() == _selectedCategoryId ||
          (p.category != null && p.category!.slug == _selectedCategoryId);

      final bool matchesSearch = _searchQuery.trim().isEmpty ||
          p.name.toLowerCase().contains(_searchQuery.trim().toLowerCase()) ||
          (p.desc != null && p.desc!.toLowerCase().contains(_searchQuery.trim().toLowerCase()));

      return matchesCategory && matchesSearch;
    }).toList();
  }

  Future<void> fetchAllCatalogData() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      // 1. Fetch Categories
      final catRes = await ApiClient.get(ApiConstants.categories);
      if (catRes['success'] == true) {
        _categories = (catRes['data'] as List).map((i) => CategoryModel.fromJson(i)).toList();
      }

      // 2. Fetch Products
      final prodRes = await ApiClient.get(ApiConstants.products);
      if (prodRes['success'] == true) {
        _products = (prodRes['data'] as List).map((i) => ProductModel.fromJson(i)).toList();
      }

      // 3. Fetch Offers
      final offerRes = await ApiClient.get(ApiConstants.offers);
      if (offerRes['success'] == true) {
        _offers = (offerRes['data'] as List).map((i) => OfferModel.fromJson(i)).toList();
      }

      // 4. Fetch Settings
      final setRes = await ApiClient.get(ApiConstants.settings);
      if (setRes['success'] == true) {
        _settings = SettingModel.fromJson(setRes['data']);
      }
    } catch (e) {
      _errorMessage = e.toString().replaceAll('Exception: ', '');
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  void setSelectedCategory(String categoryId) {
    _selectedCategoryId = categoryId;
    notifyListeners();
  }

  void setSearchQuery(String query) {
    _searchQuery = query;
    notifyListeners();
  }

  ProductModel? getProductById(int id) {
    try {
      return _products.firstWhere((p) => p.id == id);
    } catch (_) {
      return null;
    }
  }
}
