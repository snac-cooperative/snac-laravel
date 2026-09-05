import axios from 'axios';

const apiClient = axios.create({
  baseURL: `/laravel/api/concepts`,
});

let categories = [];

export function loadCategoryIds() {
  if (categories.length > 0) {
    return Promise.resolve();
  }

  return apiClient
    .get(`/categories`)
    .then((response) => {
      categories = response.data;
    })
    .catch((err) => {
      console.error('Failed to fetch categories:', err);
    });
}

export function getCategoryIds() {
  return categories;
}
