import axios from 'axios';

const apiClient = axios.create({
  baseURL: `/api/concept_sources`,
});

export default {
  async listConceptSources(perPage, sortBy, sortOrder, page) {
    try {
      const { data } = await apiClient.get({
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

  async getConceptSource(conceptSourceId) {
    try {
      const { data } = await apiClient.get(`/${conceptSourceId}`);
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },

  async createConceptSource(conceptSourceData) {
    try {
      const { data } = await apiClient.post('', conceptSourceData);
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },

  async updateConceptSource(conceptSourceId, conceptSourceData) {
    try {
      const { data } = await apiClient.patch(
        `/${conceptSourceId}`,
        conceptSourceData,
      );
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },

  async deleteConceptSource(conceptSourceId) {
    try {
      const { data } = await apiClient.delete(`/${conceptSourceId}`);
      return [null, data];
    } catch (error) {
      return [error, null];
    }
  },
};
