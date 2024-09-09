import axios from 'axios';

const apiClient = axios.create({
  baseURL: `${process.env.MIX_APP_URL}/api/concepts`,
});

export default {
  async listConcepts(perPage, sortBy, sortOrder) {
    try {
      const { data } = await apiClient.get('', {
        params: {
          per_page: perPage,
          sort_by: sortBy,
          sort_order: sortOrder,
        },
      });
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async getConcept(conceptId) {
    try {
      const { data } = await apiClient.get(`/${conceptId}`);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async createConcept(conceptData) {
    try {
      const { data } = await apiClient.post('', conceptData);
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
      return [error];
    }
  },
};
