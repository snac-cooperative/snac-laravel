import axios from 'axios';

const apiClient = axios.create({
  baseURL: `/api/concepts`,
});

export default {
  async listConcepts(perPage, sortBy, sortOrder, page) {
    try {
      const { data } = await apiClient.get('', {
        params: {
          per_page: perPage,
          sort_by: sortBy,
          sort_order: sortOrder,
          page,
        },
      });
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },

  async getConcept(conceptId) {
    try {
      const { data } = await apiClient.get(`/${conceptId}`);
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },

  async createConcept(conceptData) {
    try {
      const { data } = await apiClient.post('', conceptData);
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },

  async updateConcept(conceptId, conceptData) {
    try {
      const { data } = await apiClient.patch(`/${conceptId}`, conceptData);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async deleteConcept(conceptId) {
    try {
      const { data } = await apiClient.delete(`/${conceptId}`);
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },
};
