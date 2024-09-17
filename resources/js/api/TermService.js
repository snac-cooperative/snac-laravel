import axios from 'axios';

const apiClient = axios.create({
  baseURL: `api/terms`,
});

export default {
  async listTerms(perPage, sortBy, sortOrder, page) {
    try {
      const { data } = await apiClient.get({
        params: {
          perPage,
          sort_by: sortBy,
          sort_order: sortOrder,
          page,
        },
      });
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async getTerm(termId) {
    try {
      const { data } = await apiClient.get(`/${termId}`);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async createTerm(termData) {
    try {
      const { data } = await apiClient.post('', termData);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async updateTerm(termId, termData) {
    try {
      const { data } = await apiClient.patch(`/${termId}`, termData);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async deleteTerm(termId) {
    try {
      const { data } = await apiClient.delete(`/${termId}`);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },
};
