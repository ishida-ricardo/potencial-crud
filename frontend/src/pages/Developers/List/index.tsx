import React, { useState, useEffect, ChangeEvent, MouseEvent } from 'react';
import { Table, Button, Pagination, Form, Row, Col } from 'react-bootstrap';
import { useHistory } from 'react-router-dom';
import Moment from 'react-moment';
import api from '../../../services/api';

import './index.css';

interface IDeveloper {
  id: number;
  name: string;
  sex: string;
  age: number;
  hobby: string;
  birth_date: string;
  created_at: string;
}

const Developers: React.FC = () => {
    const [developers, setDevelopers] = useState<IDeveloper[]>([]);
    const [filter, setFilter] = useState<any>({});
    const [links, setLinks] = useState<any>([]);
    const history = useHistory();

    useEffect(() => {
        loadDevelopers();
    }, []);

  async function loadDevelopers() {
    const response = await api.get('/developers');
    setDevelopers(response.data.data);
    setLinksPagination(response.data.links);
  }

  function setLinksPagination(links: Array<any>) {
    links.shift();
    links.pop();
    setLinks(links);
  }

  async function changePagination(e: MouseEvent<HTMLElement>, page: number, active: boolean) {
    if(active)
      return;

    const response = await api.get('/developers?page='+page);
    setDevelopers(response.data.data);
    setLinksPagination(response.data.links);
  }

  async function removeDeveloper(id: number) {
    if(window.confirm('Deseja realmente remover?')) {
      await api.delete(`/developers/${id}`);
      loadDevelopers();
    }
  }

  function newDeveloper() {
    history.push('/developers/form');
  }

  function editDeveloper(id: number) {
    history.push(`/developers/form/${id}`);
  }
  function viewDeveloper(id: number) {
    history.push(`/developers/${id}`);
  }

  function updateFilter(e: ChangeEvent<HTMLInputElement|HTMLSelectElement>) {
    setFilter({
      ...filter,
      [e.target.name]: e.target.value,
    });
  }

  async function onSubmit(e: ChangeEvent<HTMLFormElement>) {
    e.preventDefault();

    var str = [];
    for (var p in filter)
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(filter[p]));
    const query = str.join("&");

    const response = await api.get('/developers?'+query);
    setDevelopers(response.data.data);
    setLinksPagination(response.data.links);
  }

  return (
    <div className="container">
      <br />
      <div className="developer-header">
        <h1>Developers</h1>
        <Button variant="dark" onClick={newDeveloper}>
          Cadastrar
        </Button>
      </div>
      <br />

      <Form onSubmit={onSubmit}>
        <Row>
          <Col>
            <Form.Label>Nome</Form.Label>
            <Form.Control
              type="text"
              name="name"
              value={filter.name}
              onChange={(e: ChangeEvent<HTMLInputElement>) => updateFilter(e)}
            />
          </Col>
          <Col>
            <Form.Label>Sexo</Form.Label>
            <Form.Select
              name="sex"
              value={filter.sex}
              onChange={(e: ChangeEvent<HTMLSelectElement>) => updateFilter(e)}
              placeholder="sexo"
            >
              <option></option>
              <option value="F">Feminino</option>
              <option value="M">Masculino</option>
            </Form.Select>
          </Col>
          <Col>
            <Form.Label>Idade</Form.Label>
            <Form.Control
              type="number"
              name="age"
              value={filter.age}
              min="2"
              onChange={(e: ChangeEvent<HTMLInputElement>) => updateFilter(e)}
            />
          </Col>
          <Col>
            <Form.Label>Hobby</Form.Label>
            <Form.Control
              type="text"
              name="hobby"
              value={filter.hobby}
              onChange={(e: ChangeEvent<HTMLInputElement>) => updateFilter(e)}
            />
          </Col>
          <Col>
            <Form.Label>Data de Nascimento</Form.Label>
            <Form.Control
              type="date"
              name="birth_date"
              value={filter.birth_date}
              onChange={(e: ChangeEvent<HTMLInputElement>) => updateFilter(e)}
              placeholder="Data de Nascimento"
            />
          </Col>
          <Col className="btn-search">
            <Button variant="dark" type="submit">
              Pesquisar
            </Button>
          </Col>
        </Row>
      </Form>
      <br />
      
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Idade</th>
            <th>Hobby</th>
            <th>Data de Nascimento</th>
            <th>Criado em</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          {developers.map((developer) => (
            <tr key={developer.id}>
              <td>{developer.name}</td>
              <td>{developer.sex}</td>
              <td>{developer.age}</td>
              <td>{developer.hobby}</td>
              <td>
                <Moment format="DD/MM/YYYY">
                  {developer.birth_date}
                </Moment>
              </td>
              <td>
                <Moment format="DD/MM/YYYY H:m">
                  {developer.created_at}
                </Moment>
              </td>
              <td>
                <Button
                  size="sm"
                  onClick={() => editDeveloper(developer.id)}
                >
                  Editar
                </Button>{' '}
                <Button
                  size="sm"
                  variant="secondary"
                  onClick={() => viewDeveloper(developer.id)}
                >
                  Visualizar
                </Button>{' '}
                <Button
                  size="sm"
                  variant="danger"
                  onClick={() => removeDeveloper(developer.id)}
                >
                  Remover
                </Button>{' '}
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
      <div>
        <Pagination>
          {links.map((link: any, key: any) => (
            <Pagination.Item key={key} active={link.active} onClick={e => changePagination(e, key+1, link.active)}>
              {key+1}
            </Pagination.Item>
          ))}
        </Pagination>
      </div>
    </div>
  );
};

export default Developers;