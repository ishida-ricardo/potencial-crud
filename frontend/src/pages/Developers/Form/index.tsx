import React, { useState, useEffect, ChangeEvent } from 'react';
import { useHistory, useParams } from 'react-router-dom';
import { Button, Form, InputGroup } from 'react-bootstrap';
import api from '../../../services/api';

import './index.css';

interface IDeveloper {
  name: string;
  sex: string;
  age: number;
  hobby: string;
  birth_date: string;
}

interface IParams {
  id: string;
}

const Developers: React.FC = () => {
  const history = useHistory();
  const { id } = useParams<IParams>();
  const [validated, setValidated] = useState(false);

  const [model, setModel] = useState<IDeveloper>({
    name: '',
    sex: '',
    age: 0,
    hobby: '',
    birth_date: '',
  });

  useEffect(() => {
    if (id !== undefined) {
      findDeveloper(id);
    }
  }, [id]);

  function updatedModel(e: ChangeEvent<HTMLInputElement|HTMLSelectElement>) {
    setModel({
      ...model,
      [e.target.name]: e.target.value,
    });
  }

  async function onSubmit(e: ChangeEvent<HTMLFormElement>) {
    e.preventDefault();

    const form = e.currentTarget;
    if (form.checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    }

    setValidated(true);

    try {
      let response = null;
      if (id !== undefined) {
        response = await api.put(`/developers/${id}`, model);
      } else {
        response = await api.post('/developers', model);
      }
      history.push("/developers/"+response.data.id);
    } catch (error) {
      console.log(error); 
    }
  }

  async function findDeveloper(id: string) {
    const response = await api.get(`developers/${id}`);
    setModel({
      name: response.data.name,
      sex: response.data.sex,
      age: response.data.age,
      hobby: response.data.hobby,
      birth_date: response.data.birth_date,
    });
  }

  function backToList() {
    history.push('/');
  }

  return (
    <div className="container">
      <br />
      <div className="developer-header">
        <h3>Novo Desenvolvedor</h3>
        <Button variant="dark" onClick={backToList}>
          Voltar
        </Button>
      </div>
      <br />
      <div>
        <Form noValidate validated={validated} onSubmit={onSubmit}>
          <Form.Group className="mb-3">
            <Form.Label>Nome</Form.Label>
            <InputGroup hasValidation>
              <Form.Control
                type="text"
                name="name"
                required
                value={model.name}
                onChange={(e: ChangeEvent<HTMLInputElement>) => updatedModel(e)}
              />
              <Form.Control.Feedback type="invalid">
                Campo obrigatório
              </Form.Control.Feedback>
            </InputGroup>
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label>Sexo</Form.Label>
            <InputGroup hasValidation>
              <Form.Select
                name="sex"
                value={model.sex}
                required
                onChange={(e: ChangeEvent<HTMLSelectElement>) => updatedModel(e)}
              >
                <option></option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
              </Form.Select>
              <Form.Control.Feedback type="invalid">
                Campo obrigatório
              </Form.Control.Feedback>
            </InputGroup>
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label>Idade</Form.Label>
            <InputGroup hasValidation>
              <Form.Control
                type="number"
                name="age"
                required
                value={model.age}
                min="2"
                onChange={(e: ChangeEvent<HTMLInputElement>) => updatedModel(e)}
              />
              <Form.Control.Feedback type="invalid">
                Campo obrigatório e deve ser maior que 1
              </Form.Control.Feedback>
            </InputGroup>
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label>Hobby</Form.Label>
            <InputGroup hasValidation>
              <Form.Control
                type="text"
                name="hobby"
                required
                value={model.hobby}
                onChange={(e: ChangeEvent<HTMLInputElement>) => updatedModel(e)}
              />
              <Form.Control.Feedback type="invalid">
                Campo obrigatório
              </Form.Control.Feedback>
            </InputGroup>
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label>Data de nascimento</Form.Label>
            <InputGroup hasValidation>
              <Form.Control
                type="date"
                name="birth_date"
                required
                value={model.birth_date}
                onChange={(e: ChangeEvent<HTMLInputElement>) => updatedModel(e)}
              />
              <Form.Control.Feedback type="invalid">
                Campo obrigatório
              </Form.Control.Feedback>
            </InputGroup>
          </Form.Group>

          <Button variant="dark" type="submit" className="btn-submit">
            Salvar
          </Button>
        </Form>
      </div>
    </div>
  );
};

export default Developers;