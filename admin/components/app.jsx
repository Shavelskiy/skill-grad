import React, { useState } from 'react';
import { BrowserRouter } from 'react-router-dom';

import './app.scss'
import Sidebar from './sidebar/sidebar';
import Header from './header/header';
import Preloader from './preloader/preloader';
import PageSwitcher from '../pages/page-switcher';

const App = () => {
  const [sidebarOpened, setSidebarOpened] = useState(true);

  return (
    <BrowserRouter basename={'/admin'}>
      <div className={`main ${!sidebarOpened ? 'active' : ''}`}>
        <Sidebar
          toggle={() => setSidebarOpened(!sidebarOpened)}
          opened={sidebarOpened}
        />
        <div className="main-content">
          <Header/>
          <Preloader/>
          <PageSwitcher/>
        </div>
      </div>
    </BrowserRouter>
  );
}

export default App;
