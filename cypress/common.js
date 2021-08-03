export const LOGIN_DATA = {
    'username': 'test@test.com',
    'password': '123456'
};

export const SITE_URL = 'http://127.0.0.1:8000';

export const LOGIN_PAGE = SITE_URL+'/login';
export const REGISTER_PAGE = SITE_URL+'/register';
export const PRODUCTS_PAGE = SITE_URL+'/products';
export const LOGOUT_PAGE = SITE_URL+'/logout';

export const apiUrls = {
    'login': SITE_URL + '/api/login', 
    'products': SITE_URL+ '/api/products?stock=1&sort=total_on_hand|desc&page=1&size=10',
    'products_stock': SITE_URL+ '/api/products?stock=1&page=1&size=10',
    'products_stock_available_only': SITE_URL+ '/api/products?stock=1&page=1&size=10&availability=yes',
    'product_crud': SITE_URL + '/api/products', 
    'import_product': SITE_URL + '/api/products/import', 

};