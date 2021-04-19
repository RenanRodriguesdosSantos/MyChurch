import axios from 'axios';

/**
 * Classe base para a criação de serviços
 * Aqui é implementado os métodos básicos para integração com uma API REST.
 * Está é uma classe abstrata, é necessário herdar de BaseService para utiliza-la
 */


export default class BaseService {
  static domain = '';
  static data = '';

  constructor(domain) {
    this.domain = domain;
  }

  /**
   * Metodo responsavel por realizar um get por id.
   * @param {*} id
   */
  get(id) {
    return axios.get(`${this.domain}/${id}`).then(this.mapDataFromResponse);
  }

  /**
   * Metodo responsavel por realizar um get com filtros.
   * @param {*} filters
   */
  query(filters = {}) {
    return axios
      .get(this.domain, {
        params: filters,
      })
      .then(this.mapDataFromResponse);
  }

  static manyRequests(promises) {
    return axios
      .all(promises)
      .then(this.mapDataFromResponse);
  }

  /**
   * Metodo responsavel por realizar um get com filtros e paginado.
   * @param {*} filters
   * @param {*} perPage
   * @param {*} page
   */
  paginateQuery(filters = {}, perPage = 10, page = 1) {
    const defaultFilters = Object.assign({ perPage, page }, filters);

    return this.query(defaultFilters);
  }

  /**
   * Metodo responsavel por realizar um post ou put.
   * Caso o objeto possua id ele realiza put.
   * @param {*} data
   */
  save(data, reqConfig = {}, subPath = null) {
    let promise = null;
    const id = (data instanceof FormData) ? data.get('id') : data.id;
    const fullPath = (subPath) ? `${this.domain}/${subPath}` : this.domain;
    if (id === undefined || id === null) {
      promise = axios.post(fullPath, data, reqConfig);
    } else {
      promise = axios.put(`${fullPath}/${id}`, data, reqConfig);
    }

    return promise.then(this.mapDataFromResponse);
  }

  /**
   * Metodo responsavel por realizar um metodo de delete.
   * @param {*} id
   */
  destroy(id) {
    return axios.delete(`${this.domain}/${id}`).then(this.mapDataFromResponse);
  }

  /**
   * Metodo responsavel por realizar requests dinamicos.
   * @param {*} method
   * @param {*} path
   * @param {*} data
   * @param {*} options
   */
  request(method, path, data = {}, options = {}) {
    return BaseService.request(method, `${this.domain}/${path}`, data, options);
  }

   static request(method, path, data = {}, options = {}) {
    const defaultOptions = Object.assign(
      { url: path, overridePath: false },
      options,
      { method, data },
    );

    if (defaultOptions.overridePath) defaultOptions.url = path;
    delete defaultOptions.overridePath;

    return axios.request(defaultOptions).then(this.mapDataFromResponse);
  }

  mapDataFromResponse = response => response.data;
}
