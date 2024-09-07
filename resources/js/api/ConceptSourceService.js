import axios from 'axios';

const apiClient = axios.create({
  baseURL: `${process.env.MIX_APP_URL}/api/concept_sources`,
});

export default {
  async listConceptSources() {
    try {
      const { data } = await apiClient.get();
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async getConceptSource(conceptSourceId) {
    try {
      const { data } = await apiClient.get(`/${conceptSourceId}`);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async createConceptSource(conceptSourceData) {
    try {
      const { data } = await apiClient.post('', conceptSourceData);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async updateConceptSource(conceptSourceId, conceptSourceData) {
    try {
      const { data } = await apiClient.post(
        `/${conceptSourceId}`,
        conceptSourceData,
      );
      return [null, data];
    } catch (error) {
      return [error];
    }
  },

  async deleteConceptSource(conceptSourceId) {
    try {
      const { data } = await apiClient.delete(`/${conceptSourceId}`);
      return [null, data];
    } catch (error) {
      return [error];
    }
  },
};
