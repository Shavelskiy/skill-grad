import React, {useState} from 'react';
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs';
import PanelTitle from '../../components/panel/panel-title';
import {TextInput, NumberInput, SaveButton} from "../../components/ui/inputs";
import {Redirect} from 'react-router';

const breadcrumbs = [
  {
    title: 'Главная',
    link: '/',
  },
  {
    title: 'Список тегов',
    link: '/tag',
  },
  {
    title: 'Создание тега',
    link: null,
  }
];

export default function TagCreate() {
  const [name, setName] = useState('');
  const [sort, setSort] = useState(0);
  const [redirect, setRedirect] = useState(false);

  const save = () => {
    setRedirect(true);
  }

  if (redirect) {
    return (
      <Redirect to="/tag" />
    )
  }

  return (
    <div className="page">
      <Breadcrumbs items={breadcrumbs}/>

      <div className="portlet w-50">
        <PanelTitle
          title={'Создание тега'}
          icon={'fa fa-info'}
          withButton={false}
        />

        <div className="body">
          <TextInput
            value={name}
            setValue={setName}
          />
          <NumberInput
            value={sort}
            setValue={setSort}
          />

          <SaveButton handler={save} />
        </div>
      </div>
    </div>
  );
};
