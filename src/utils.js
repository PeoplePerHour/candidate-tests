import qs from 'qs';

export const parseParamsFromLink = link => {
  if (!link) return;
  const querystringArray = link.split('?');

  return !querystringArray[1] ? {} : qs.parse(querystringArray[1]);
};
