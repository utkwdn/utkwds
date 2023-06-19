import { ElementType, HTMLAttributes, FC } from 'react';

interface ComponentProps extends HTMLAttributes<HTMLOrSVGElement> {
  level?: 'h2' | 'h3' | 'h4' | 'h5' | 'h6';
}

const HeadingDynamic: FC<ComponentProps> = ({ level: Tag = 'h2', ...otherProps }) => {
  console.log('HeadingLevel: ' + Tag);
  return <Tag {...otherProps} />;
};

export {HeadingDynamic};
