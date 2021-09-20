import React, { useState, useEffect } from 'react';
import { useHistory, useParams } from 'react-router-dom';
import { Button, Card } from 'react-bootstrap';
import Moment from 'react-moment';
import api from '../../../services/api';

interface IDeveloper {
  id: number;
  name: string;
  sex: string;
  age: number;
  hobby: string;
  birth_date: string;
}

interface IParams {
  id: string;
}

const Detail: React.FC = () => {
  const history = useHistory();
  const { id } = useParams<IParams>();
  const [developer, setDeveloper] = useState<IDeveloper>();

  useEffect(() => {
    findDeveloper();
  }, [id]);

  function backToList() {
    history.push('/');
  }

  async function findDeveloper() {
    const response = await api.get<IDeveloper>(`/developers/${id}`);
    setDeveloper(response.data);
  }

  return (
    <div className="container">
      <br />
      <div className="developer-header">
        <h1>Desenvolvedor - Detalhes</h1>
        <Button variant="dark" onClick={backToList}>
          Voltar
        </Button>
      </div>
      <br />
      <Card>
        <Card.Body>
          <Card.Text>
            <strong>Nome: </strong>
            {developer?.name}
          </Card.Text>
          <Card.Text>
            <strong>Sexo: </strong>
            {developer?.sex}
          </Card.Text>
          <Card.Text>
            <strong>Hobby: </strong>
            {developer?.hobby}
          </Card.Text>
          <Card.Text>
            <strong>Idade: </strong>
            {developer?.age}
          </Card.Text>
          <Card.Text>
            <strong>Nascido em: </strong>
            <Moment format="DD/MM/YYYY">
              {developer?.birth_date}
            </Moment>
          </Card.Text>
        </Card.Body>
      </Card>
    </div>
  );
};

export default Detail;