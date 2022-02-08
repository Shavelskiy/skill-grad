import React  from 'react'
import { NumberInput, SaveButton, TextInput, BooleanInput, Wysiwyg } from '../../components/ui/inputs'


const FaqForm = ({item, setItem, disable, save}) => {
  return (
    <form>
      <TextInput
        value={item.title}
        setValue={(title) => setItem({...item, title: title})}
        label="Заголовок"
      />

      <NumberInput
        value={item.sort}
        setValue={(sort) => setItem({...item, sort: sort})}
        label="Сортировка"
      />

      <BooleanInput
        checked={item.active}
        setValue={(value) => setItem({...item, active: value})}
        label="Активность"
      />

      <Wysiwyg
        value={item.content}
        setValue={(content) => setItem({...item, content: content})}
        label="Контент"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default FaqForm
