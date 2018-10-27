import { schema } from 'normalizr';

const CHARACTER = new schema.Entity('characters');

export const Schemas = {
  CHARACTER,
  CHARACTER_ARRAY: { results: [CHARACTER] }
};
