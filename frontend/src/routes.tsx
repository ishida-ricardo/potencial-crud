import React from 'react';
import { Switch, Route } from 'react-router-dom';

import DevelopersList from './pages/Developers/List';
import DevelopersForm from './pages/Developers/Form';
import DevelopersDetail from './pages/Developers/Detail';

const Routes: React.FC = () => {
  return (
    <Switch>
      <Route path="/" exact component={DevelopersList} />
      <Route path="/developers/form" exact component={DevelopersForm} />
      <Route path="/developers/form/:id" exact component={DevelopersForm} />
      <Route path="/developers/:id" exact component={DevelopersDetail} /> 
    </Switch>
  );
};

export default Routes;